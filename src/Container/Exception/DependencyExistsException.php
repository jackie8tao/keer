<?php
/**
 * (c) Jackie Tao <jackie8tao@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Date: 18-11-30, Time: 上午1:53
 */

namespace Keer\Container\Exception;

/**
 * Class DependencyExistsException
 * @package Keer\Container\Exception
 */
class DependencyExistsException extends ContainerException
{
    // 依赖已经存在，不可重复注册
}