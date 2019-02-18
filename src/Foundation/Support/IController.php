<?php
/**
 * (c) Jackie Tao <jackie8tao@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Date: 19-2-18, Time: 下午3:43
 */

namespace Keer\Foundation\Support;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * 应用控制器接口
 * Interface IController
 * @package Keer\Foundation\Support
 */
interface IController
{
    /**
     * 获取控制器处理的请求对象
     * @return Request
     */
    public function request() : Request;

    /**
     * 获取控制器的返回对象
     * @return Response
     */
    public function response() : Response;
}