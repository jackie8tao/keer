<?php
/**
 * (c) Jackie Tao <jackie8tao@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Date: 18-12-3, Time: 下午4:31
 */

use Keer\Foundation\Pantheon;

if (!function_exists('app')) {
    /**
     * 获取web应用对象
     * @return Pantheon
     */
    function app()
    {
        return Pantheon::getInstance();
    }
}

if (!function_exists('klog')) {
    /**
     * 获取系统日志组件
     * @return \Monolog\Logger
     */
    function klog()
    {
        return app()->take('klog');
    }
}

if (!function_exists('kconfig')) {
    /**
     * 获取日志读取组件
     * @return \Noodlehaus\Config
     */
    function kconfig()
    {
        return app()->take('kconfig');
    }
}