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

use Symfony\Component\HttpFoundation\Request;

abstract class AbstractMiddleware implements IMiddleware
{
    /** @var Request */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}