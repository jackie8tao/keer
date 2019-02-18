<?php
/**
 * (c) Jackie Tao <jackie8tao@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Date: 18-11-29, Time: 下午 5:39
 */

namespace Keer\Foundation;

use FastRoute\Dispatcher;
use FastRoute\Dispatcher\GroupCountBased;
use FastRoute\RouteCollector;
use Keer\Container\Container;
use Keer\Container\IServiceProvider;
use Keer\Foundation\Services\ConfigService;
use Keer\Foundation\Services\LogService;
use Keer\Foundation\Services\RouteService;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * 万物自此开始，由此而终结！
 * Class Pantheon
 * @package Keer\Foundation
 */
class Pantheon extends Container
{
    /** @var string 系统根目录 */
    protected $rootpath;

    /** @var string 应用目录 */
    protected $appPath;

    /** @var string 配置目录 */
    protected $configPath;

    /** @var string 存储目录 */
    protected $storagePath;

    /**
     * Pantheon constructor.
     * @param string|null $path
     */
    public function __construct(string $path = null)
    {
        if ($path) {
            $this->setAllPath($path);
        }
        $this->bootstrap();
    }

    /**
     * 应用自启动部分，主要完成服务组件的启动。
     */
    protected function bootstrap()
    {
        static::setInstance($this);
        foreach ($this->initialServices() as $service) {
            /** @var IServiceProvider $obj */
            $obj = new $service();
            $obj->initialize();
        }
    }

    /**
     * 设置系统所有相关目录
     * @param string $path 根目录
     */
    protected function setAllPath(string $path)
    {
        $this->rootpath = $path;
        $this->storagePath = $this->rootPath() . DIRECTORY_SEPARATOR . 'storage';
        $this->appPath = $this->rootPath() .DIRECTORY_SEPARATOR . 'app';
        $this->configPath = $this->rootPath() . DIRECTORY_SEPARATOR . 'config';
    }

    /**
     * 获取程序根目录路径
     * @return string 应用程序的根目录
     */
    public function rootPath(): string
    {
        return $this->rootpath;
    }

    /**
     * 获取系统存储目录
     * @return string
     */
    public function storagePath() : string
    {
        return $this->storagePath;
    }

    /**
     * 获取系统配置目录
     * @return string
     */
    public function configPath() : string
    {
        return $this->configPath;
    }

    /**
     * 获取系统应用目录
     * @return string
     */
    public function appPath() : string
    {
        return $this->appPath;
    }

    /**
     * 处理web请求
     * @param HttpRequest $request
     * @param HttpResponse $response
     */
    public function handle(HttpRequest $request, HttpResponse $response = null)
    {
        /** @var RouteCollector $routes */
        $routes = $this->take('kroutes');
        $dispatcher = new GroupCountBased($routes->getData());
        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getBasePath());

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                if ($str = $this->get_require_contents(__DIR__ . '/404.php')) {
                    $response = new HttpResponse($str, 404, ['content-type' => 'text/html']);
                }
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                if ($str = $this->get_require_contents(__DIR__ . '/405.php')) {
                    $response = new HttpResponse($str, 405,  ['content-type' => 'text/html']);
                }
                break;
            case Dispatcher::FOUND:
                $request->attributes = new ParameterBag($routeInfo[2]);
                $handlers = explode('@', $routeInfo[1]);
                $controller = new $handlers[0]();
                $method = $handlers[1];
                $controller->{$method}($request, $response);
                break;
        }

        echo $response;
    }

    /**
     * 获取require引入文件的内容
     * @param string $filename
     * @return string|false
     */
    protected function get_require_contents(string $filename)
    {
        if (is_file($filename)) {
            ob_start();
            require_once $filename;
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        }

        return false;
    }

    /**
     * 需要初始化的服务组件列表
     * @return array
     */
    protected function initialServices(): array
    {
        return [
            LogService::class, ConfigService::class, RouteService::class,
        ];
    }
}