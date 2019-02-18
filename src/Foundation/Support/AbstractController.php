<?php
/**
 * (c) Jackie Tao <jackie8tao@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Date: 19-2-18, Time: 下午3:26
 */

namespace Keer\Foundation\Support;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * 应用控制器抽象类
 * Interface IController
 * @package Keer\Foundation\Support
 */
abstract class AbstractController implements IController
{
    /**
     * @var Request web请求对象
     */
    protected $request;

    /**
     * @var Response web请求的返回对象
     */
    protected $response;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * 重定向到url
     * @param string $url
     * @param int $status
     * @param array $headers
     */
    protected function redirect(string $url, int $status = 302, array $headers = [])
    {
        $this->response = new RedirectResponse($url, $status, $headers);
    }

    /**
     * 设置返回值
     * @param array $val
     * @param int $status
     * @param array $headers
     */
    protected function content(array $val, int $status = Response::HTTP_OK, array $headers = [])
    {
        $this->response = JsonResponse::create($val, $status, $headers);
    }

    /**
     * 获取控制器处理的请求对象
     * @return Request
     */
    public function request(): Request
    {
        return $this->request;
    }

    /**
     * 获取控制器的返回对象
     * @return Response
     */
    public function response(): Response
    {
        return $this->response;
    }
}