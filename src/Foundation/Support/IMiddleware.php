<?php
/**
 * (c) Jackie Tao <jackie8tao@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Date: 19-2-18, Time: 下午4:05
 */

namespace Keer\Foundation\Support;

use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * 系统中间件接口
 * Interface IMiddleware
 * @package Keer\Foundation\Support
 */
interface IMiddleware
{
    /**
     * 执行错误时，返回相关提示
     * @return HttpResponse
     */
    public function message() : HttpResponse;

    /**
     * 执行中间件
     * @return bool
     */
    public function execute() : bool;
}