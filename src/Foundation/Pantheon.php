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
    private function __construct(string $path = null)
    {
        if ($path) {
            $this->rootpath = $path;
        }
        $this->bootstrap();
    }

    /**
     * 应用自启动部分，主要完成服务组件的启动。
     */
    protected function bootstrap()
    {
        foreach ($this->initialServices() as $service) {
            /** @var IServiceProvider $obj */
            $obj = new $service();
            $obj->provides();
        }
    }

    /**
     * 设置系统所有相关目录
     */
    protected function setAllPath()
    {

    }

    /**
     * 获取程序根目录路径
     * @return string 应用程序的根目录
     */
    public function rootpath(): string
    {
        return $this->rootpath;
    }

    /**
     * 需要初始化的服务组件列表
     * @return array
     */
    protected function initialServices(): array
    {
        return [
            LogService::class
        ];
    }
}