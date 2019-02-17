<?php
/**
 * (c) Jackie Tao <jackie8tao@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Date: 18-12-3, Time: 下午4:12
 */

namespace Keer\Container\Exception;

/**
 * Class InvalidServiceException
 * @package Keer\Container\Exception
 */
class InvalidServiceException extends ContainerException
{
    // 无效的服务，可能服务类名不存在
}