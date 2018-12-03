<?php
/**
 * (c) Jackie Tao <jackie8tao@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Date: 18-12-3, Time: 下午4:41
 */

namespace Keer\Container\ServiceProvider;

use Keer\Container\IContainer;
use Keer\Container\IServiceProvider;

/**
 * Class GenericService, 一般性服务的抽象方法
 * @package Keer\Container\ServiceProvider
 */
abstract class GenericService implements IServiceProvider
{
    /** @var IContainer 服务存储的容器 */
    protected $container;

    /** @var array 服务名称 */
    protected $aliases = [];

    public function __construct(IContainer $container)
    {
        $this->container = $container;
    }
}