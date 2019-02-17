<?php
/**
 * (c) Jackie Tao <jackie8tao@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Date: 18-11-30, Time: 上午2:06
 */

namespace Keer\Container;

/**
 * 服务接口
 * Interface IServiceProvider
 * @package Keer\Container
 */
interface IServiceProvider
{
    /**
     * 服务组件的别称
     * @return array
     */
    public function aliases() : array;

    /**
     * 服务组件对象
     * @return mixed|void
     */
    public function provides();
}