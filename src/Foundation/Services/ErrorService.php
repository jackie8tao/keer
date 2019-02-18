<?php
/**
 * (c) Jackie Tao <jackie8tao@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Date: 19-2-18, Time: 下午2:18
 */

namespace Keer\Foundation\Services;

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;
use Keer\Container\ServiceProvider\GenericService;

/**
 * 提供美化的错误处理机制
 * Class ErrorService
 * @package Keer\Foundation\Services
 */
class ErrorService extends GenericService
{
    public function __construct()
    {
        $this->aliases = ['whoops'];
        $this->component = new Run();
    }

    /**
     * 设置组件
     * @return void
     */
    protected function setup()
    {
        $this->component->pushHandler(new PrettyPageHandler());
        $this->component->register();
    }
}