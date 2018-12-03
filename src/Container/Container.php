<?php
/**
 * (c) Jackie Tao <jackie8tao@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Date: 18-11-28, Time: 下午8:21
 */

namespace Keer\Container;

use \ReflectionClass;
use \ReflectionException;
use Keer\Container\Exception\InvalidServiceException;
use Keer\Container\Exception\ServiceExistException;
use Keer\Container\Exception\ContainerException;
use Keer\Container\Exception\DependencyNotFoundException;
use Keer\Container\Exception\DependencyExistsException;
use Keer\Container\Exception\InvalidDependencyException;

/**
 * Class Container，基础容器对象
 * @package Keer\Container
 */
class Container implements IContainer
{
    /** @var array 向容器中注册的对象 */
    protected $dependencies = [];

    /** @var array 容器中注册的服务组件 */
    protected $services = [];

    /**
     * 向容器中注册对象
     * @param string $alias , 对象名称
     * @param null $class , 依赖值，默认为空
     * @param array|null $parameters , 依赖所需要的参数
     * @throws DependencyExistsException
     * @throws InvalidDependencyException
     */
    public function register(string $alias, $class = null, array $parameters = null)
    {
        if (isset($this->dependencies[$alias]))
            throw new DependencyExistsException();

        $def = isset($class) ? $class : $alias;
        if (!is_string($def) && !is_callable($def))
            throw new InvalidDependencyException('依赖只能为类名或者闭包');

        $this->dependencies[$alias] = [
            "def" => $def,
            "args" => $parameters
        ];
    }

    /**
     * 从容器中解析出指定对象
     * @param string $name , 对象名称
     * @return mixed
     * @throws DependencyNotFoundException
     * @throws ContainerException
     */
    public function take(string $name)
    {
        if (!isset($this->dependencies[$name]))
            throw new DependencyNotFoundException();

        $def = $this->dependencies[$name]['def'];
        $args = $this->dependencies[$name]['args'];
        if (is_string($def)) {
            try {
                return $this->parseClass($def, $args);
            } catch (ReflectionException $e) {
                throw new ContainerException();
            }
        }

        if (is_callable($def)) {
            return call_user_func_array($def, $args);
        }

        throw new ContainerException("未找到{$name}");
    }

    /**
     * 向容器中添加服务组件
     * @param string $service
     * @throws ServiceExistException
     * @throws InvalidServiceException
     */
    public function set(string $service)
    {
        if (isset($this->services[$service])) {
            throw new ServiceExistException('服务已经添加！');
        }

        if (!class_exists($service)) {
            throw new InvalidServiceException('服务类不存在!');
        }

        /** @var IServiceProvider $serviceProvider */
        $serviceProvider = new $service($this);
        if (!($serviceProvider instanceof IServiceProvider)) {
            throw new InvalidServiceException('服务类必须实现IServiceProvider接口');
        }

        $this->services[$service] = [
            'aliases' => $serviceProvider->aliases(),
            'object' => $serviceProvider->provides()
        ];
    }

    /**
     * 从容器中获取服务组件
     * @param string $alias , 服务名称
     * @return mixed
     * @throws ContainerException
     */
    public function fetch(string $alias)
    {
        foreach ($this->services as $key => $value) {
            $found = array_search($alias, $value['aliases']) || $key == $alias;
            if ($found) {
                return $this->services[$key]['object'];
            }
        }

        throw new ContainerException("未找到服务组件:{$alias}");
    }

    /**
     * 利用反射自动构造对象
     * @param string $classname , 类名称
     * @param array|null $args , 类构造函数所需参数
     * @return object
     * @throws ReflectionException
     */
    protected function parseClass(string $classname, array $args = null)
    {
        $classReflection = new ReflectionClass($classname);
        $classArgs = $classReflection->getConstructor()->getParameters();
        if (count($classArgs) <= 0)
            return $classReflection->newInstance();

        $invokeArgs = [];
        foreach ($classArgs as $param) {
            $pName = $param->getName();
            if ($param->isOptional()) {
                $invokeArgs[$pName] = $args && isset($args[$pName]) ?
                    $args[$pName] : $param->getDefaultValue();
            } else {
                $argClass = $param->getClass();
                if ($args && isset($args[$pName])) {
                    $ps = $args[$pName];
                    $invokeArgs[$pName] = $argClass ?
                        $this->parseClass($argClass->getName(), is_array($ps) ? $ps : [$ps]) : $ps;
                } else {
                    throw new ReflectionException();
                }
            }
        }

        return $classReflection->newInstanceArgs($invokeArgs);
    }
}