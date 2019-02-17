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

use Keer\Container\Container;
use Keer\Container\IServiceProvider;
use Keer\Foundation\Services\ConfigService;
use Keer\Foundation\Services\LogService;

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
     * 需要初始化的服务组件列表
     * @return array
     */
    protected function initialServices(): array
    {
        return [
            LogService::class, ConfigService::class
        ];
    }
}