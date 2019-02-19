<?php
/**
 * (c) Jackie Tao <jackie8tao@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Date: 18-12-3, Time: 下午4:41
 */

namespace Keer\Container\ServiceProvider;

use Keer\Container\IServiceProvider;

/**
 * Class GenericService, 一般性服务的抽象方法
 * @package Keer\Container\ServiceProvider
 */
abstract class GenericService implements IServiceProvider
{
    /** @var array 服务名称 */
    protected $aliases = [];

    /** @var static 服务对象 */
    protected $component;

    /**
     * 服务组件的别称
     * @return array
     */
    public function aliases(): array
    {
        // 初始化时未设置别名，则默认使用类名
        if (empty($this->aliases)) {
            $this->aliases = [self::class];
        }

        return $this->aliases;
    }

    /**
     * 注册组件对象到容器
     */
    protected function register()
    {
        foreach ($this->aliases() as $alias) {
            kApp()->register($alias, $this->component);
        }
    }

    /**
     * 初始化服务组件
     * @return mixed|void
     */
    public function initialize()
    {
        $this->setup();
        $this->register();
    }

    /**
     * 设置组件
     * @return void
     */
    abstract protected function setup();
}