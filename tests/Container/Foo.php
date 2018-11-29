<?php
/**
 * (c) Jackie Tao <jackie8tao@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Date: 18-11-29, Time: 下午6:27
 */

namespace Keer\Tests\Container;

/**
 * Class Foo, 容器测试使用的类
 * @package Keer\Tests\Container
 */
class Foo
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    public function __construct(int $nu, string $name)
    {
        $this->id = $nu;
        $this->name = $name;
    }

    /**
     * 获取id
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * 获取名称
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }
}