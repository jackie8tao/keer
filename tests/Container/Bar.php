<?php
/**
 * (c) Jackie Tao <jackie8tao@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Date: 18-11-29, Time: 下午6:28
 */

namespace Keer\Tests\Container;

/**
 * Class Bar, 容器测试类
 * @package Keer\Tests\Container
 */
class Bar
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var \Keer\Tests\Container\Foo
     */
    protected $foo;

    public function __construct(string $name, Foo $foo)
    {
        $this->name = $name;
        $this->foo = $foo;
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
     * 获取foo对象
     * @return \Keer\Tests\Container\Foo
     */
    public function foo(): Foo
    {
        return $this->foo;
    }
}