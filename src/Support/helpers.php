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
use Keer\Foundation\Exception\FoundationException;

if (!function_exists('app')) {
    /**
     * 获取web应用对象
     * @return bool|Pantheon
     */
    function app() {
        try {
            return Pantheon::instance();
        } catch (FoundationException $e) {
            return false;
        }
    }
}