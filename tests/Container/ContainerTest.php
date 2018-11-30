<?php
/**
 * (c) Jackie Tao <jackie8tao@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Date: 18-11-29, Time: 下午5:41
 */

namespace Keer\Tests\Container;

use PHPUnit\Framework\TestCase;
use Keer\Container\Container as KContainer;
use Keer\Container\Exception\ContainerException;
use Keer\Container\Exception\DependencyExistsException;
use Keer\Container\Exception\InvalidDependencyException;
use Keer\Container\Exception\DependencyNotFoundException;

/**
 * Class ContainerTest, 容器测试
 * @package Keer\Tests\Container
 */
class ContainerTest extends TestCase
{
    /**
     * 测试register方法是否成功
     */
    public function testRegister()
    {
        $container = new KContainer();
        try {
            // 别名，类名，参数
            $container->register("foo2", Foo::class, [
                'nu' => 12,
                'name' => 'ClassFoo'
            ]);

            // 别名，参数
            $container->register(Foo::class, null, [
                'nu' => 13, 'name' => 'ClassFoo'
            ]);

            // 别名，闭包，参数
            $container->register('foo1', function ($id, $name) {
                return new Foo($id, $name);
            }, ['nu' => 11, 'name' => 'ClassFoo']);

            // 别名，类名，参数，递归
            $container->register('foobar', FooBar::class, [
                'name' => 'ClassFooBar',
                'bar' => [
                    'name' => 'ClassBar',
                    'foo' => [
                        'nu' => 14,
                        'name' => 'ClassFoo'
                    ]
                ]
            ]);
        } catch (ContainerException $e) {
            $this->assertFalse(false);
        }
        $this->assertTrue(true);

        return $container;
    }

    /**
     * 测试容器注册函数返回的InvalidDependency异常
     * @depends testRegister
     * @param KContainer $container
     * @throws InvalidDependencyException
     * @throws DependencyExistsException
     */
    public function testInvalidDependencyException(KContainer $container)
    {
        $this->expectException(InvalidDependencyException::class);
        $foo = new Foo(15, 'ClassFoo');
        $container->register("foo3", $foo);
    }

    /**
     * 测试容器的DependencyExists异常
     * @param KContainer $container
     * @throws DependencyExistsException
     * @throws InvalidDependencyException
     * @depends testRegister
     */
    public function testDependencyExistsException(KContainer $container)
    {
        $this->expectException(DependencyExistsException::class);
        $container->register(Foo::class, null, [
            'nu'=> 16,
            'name' => 'ClassFoo'
        ]);
    }

    /**
     * 测试take方法是否成功
     * @depends testRegister
     * @param KContainer $container
     * @throws ContainerException
     * @throws DependencyNotFoundException
     */
    public function testTake(KContainer $container)
    {
        /** @var Foo $foo3 */
        $foo3 = $container->take(Foo::class);
        $this->assertEquals(13, $foo3->id(), 'Foo类名依赖解析错误');

        /** @var Foo $foo2 */
        $foo2 = $container->take('foo2');
        $this->assertEquals(12, $foo2->id(), 'Foo类名依赖解析错误');

        /** @var Foo $foo1 */
        $foo1 = $container->take('foo1');
        $this->assertEquals(11, $foo1->id(), 'Foo类名依赖解析错误');

        /** @var FooBar $foo4 */
        $foobar = $container->take('foobar');
        $this->assertEquals('ClassFooBar', $foobar->name(), '深层次嵌套');
    }

    /**
     * 测试容器的DependencyNotExists异常
     * @depends testRegister
     * @param KContainer $container
     * @throws ContainerException
     * @throws DependencyNotFoundException
     */
    public function testDependencyNotFoundException(KContainer $container)
    {
        $this->expectException(DependencyNotFoundException::class);
        $container->take('foox');
    }

    /**
     * 测试容器的Container异常
     * @depends testRegister
     * @param KContainer $container
     * @throws ContainerException
     * @throws DependencyNotFoundException
     */
    public function testContainerException(KContainer $container)
    {
        $this->expectException(ContainerException::class);
        try{
            $container->register('bar', Bar::class);
        }catch (ContainerException $e) {
            $this->assertFalse(false);
        }

        $container->take('bar');
    }
}
