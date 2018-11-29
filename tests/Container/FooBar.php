<?php
/**
 * (c) Jackie Tao <jackie8tao@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Date: 18-11-29, Time: 下午6:40
 */

namespace Keer\Tests\Container;

/**
 * Class FooBar, 容器测试类
 * @package Keer\Tests\Container
 */
class FooBar
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Bar
     */
    protected $bar;

    public function __construct(string $name, Bar $bar)
    {
        $this->name = $name;
        $this->bar = $bar;
    }

    /**
     * 获取name属性
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * 获取bar属性
     * @return Bar
     */
    public function bar(): Bar
    {
        return $this->bar;
    }
}