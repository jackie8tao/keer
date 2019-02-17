<?php
/**
 * (c) Jackie Tao <jackie8tao@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Date: 18-12-3, Time: 下午6:30
 */

namespace Keer\Foundation\Services;

use Keer\Container\ServiceProvider\GenericService;
use Keer\Foundation\Pantheon;
use Monolog\Logger as MonoLogger;
use Monolog\Handler\StreamHandler;

/**
 * 日志记录组件
 * Class LogService
 * @package Keer\Foundation\Services
 */
class LogService extends GenericService
{
    /** @var MonoLogger 日志的服务组件对象 */
    protected $component;

    public function __construct()
    {
        $this->aliases = ['log', 'keer.log'];
        $this->component = new MonoLogger('keerlog');
    }

    /**
     * 服务组件对象
     * @return mixed|void
     * @throws \Exception
     */
    public function provides()
    {
        $rootpath = app()->rootpath();
        $this->component->pushHandler(
            new StreamHandler("{$rootpath}/storage/log/keer.log", MonoLogger::DEBUG)
        );

        foreach ($this->aliases as $val) {
            app()->register($val, $this->component);
        }
    }
}
