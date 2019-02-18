<?php
/**
 * (c) Jackie Tao <jackie8tao@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Date: 19-2-17, Time: 下午11:42
 */

namespace Keer\Foundation\Services;

use FastRoute\DataGenerator\GroupCountBased;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std as StdParser;
use Keer\Container\ServiceProvider\GenericService;

/**
 * 路由组件
 * Class RouteService
 * @package Keer\Foundation\Services
 */
class RouteService extends GenericService
{
    public function __construct()
    {
        $this->aliases = ['kroutes'];
    }

    /**
     * 设置组件
     * @return mixed|void
     */
    protected function setup()
    {
        $this->component = new RouteCollector(
            new StdParser(), new GroupCountBased()
        );
    }
}