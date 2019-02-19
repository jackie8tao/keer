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

if (!function_exists('kApp')) {
    /**
     * 获取web应用对象
     * @return Pantheon
     */
    function kApp()
    {
        return Pantheon::getInstance();
    }
}

if (!function_exists('kLog')) {
    /**
     * 获取系统日志组件
     * @return \Monolog\Logger
     */
    function kLog()
    {
        return kApp()->take('klog');
    }
}

if (!function_exists('kConfig')) {
    /**
     * 获取日志读取组件
     * @return \Noodlehaus\Config
     */
    function kConfig()
    {
        return kApp()->take('kconfig');
    }
}

if (!function_exists('kRoutes')) {
    /**
     * 获取系统路由组件
     * @return \FastRoute\RouteCollector
     */
    function kRoutes()
    {
        return kApp()->take('kroutes');
    }
}

if (!function_exists('kDb'))
{

    /**
     * 获取系统Dbal组件
     * @return \Doctrine\DBAL\Connection
     */
    function kDb()
    {
        return kApp()->take('kdb');
    }
}