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
use Monolog\Logger as MonoLogger;
use Monolog\Handler\StreamHandler;

/**
 * 日志记录组件
 * Class LogService
 * @package Keer\Foundation\Services
 */
class LogService extends GenericService
{
    public function __construct()
    {
        $this->aliases = ['klog'];
        $this->component = new MonoLogger('keerlog');
    }

    /**
     * 设置组件
     * @return void
     */
    protected function setup()
    {
        $storagePath = kApp()->storagePath();
        $this->component->pushHandler(
            new StreamHandler($storagePath . '/log/keerlog.log', MonoLogger::DEBUG)
        );
    }
}
