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
use Keer\Foundation\Exception\FoundationException;
use Keer\Foundation\Services\ConfigService;
use Keer\Foundation\Services\ErrorService;
use Keer\Foundation\Services\LogService;
use Keer\Foundation\Services\RouteService;
use Keer\Foundation\Support\IController;
use Keer\Foundation\Support\IMiddleware;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpFoundation\Request;
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

    /** @var string 路由目录 */
    protected $routePath;

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
        $this->setup();
    }

    /**
     * 系统引导部分，主要完成服务组件的启动。
     */
    protected function bootstrap()
    {
        static::setInstance($this);
        $this->loadSysServices();
        $this->loadCustomServices();
    }

    /**
     * 系统设置部分，完成配置和组件设置
     */
    protected function setup()
    {
        $this->loadRoutes();
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
        $this->routePath = $this->rootPath() . DIRECTORY_SEPARATOR . 'routes';
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
     * 返回系统路由目录
     * @return string
     */
    public function routePath() : string
    {
        return $this->routePath;
    }

    /**
     * 载入路由信息
     */
    protected function loadRoutes()
    {
        $dir = $this->routePath();
        if (!is_dir($dir)) return;
        $r = opendir($dir);
        if (!$r) return;
        while (false !== ($file = readdir($r))) {
            if ('.' != $file && '..' != $file) {
                require_once $dir . DIRECTORY_SEPARATOR . $file;
            }
        }
    }

    /**
     * 处理web请求
     * @param HttpRequest $request
     */
    public function handle(HttpRequest $request)
    {
        // 执行中间件
        if (true !== ($message = $this->throughMiddlewares($request))) {
            $message->send();
            return;
        }

        /** @var RouteCollector $routes */
        $routes = $this->take('kroutes');
        $dispatcher = new GroupCountBased($routes->getData());
        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getBasePath());

        $response = null;
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
                if (!class_exists($handlers[0])) {
                    throw new FoundationException("{$handlers[0]}控制器不存在");
                }

                /** @var IController $controller */
                $controller = new $handlers[0]($request);
                $method = $handlers[1];
                $controller->{$method}();
                $response = $controller->response();
                break;
        }

        $response->send();
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
     * 载入系统组件
     */
    protected function loadSysServices()
    {
        $cores = [
            LogService::class, ConfigService::class, RouteService::class,
            ErrorService::class
        ];

        foreach ($cores as $service) {
            /** @var IServiceProvider $obj */
            $obj = new $service();
            $obj->initialize();
        }
    }

    /**
     * 载入自定义组件
     */
    protected function loadCustomServices()
    {
        $services = kconfig()->get('app.services');

        foreach ($services as $service) {
            if (!class_exists($service)) continue;
            /** @var IServiceProvider $obj */
            $obj = new $service;
            $obj->initialize();
        }
    }

    /**
     * 请求处理之前，执行中间件
     * @param Request $request
     * @return mixed
     */
    protected function throughMiddlewares(Request $request)
    {
        $middlewares = kconfig()->get('app.middlewares');

        foreach ($middlewares as $middleware) {
            if (!class_exists($middlewares)) continue;
            /** @var IMiddleware $obj */
            $obj = new $middleware($request);
            if (!$obj->execute()) {
                return $obj->message();
            }
        }

        return true;
    }
}