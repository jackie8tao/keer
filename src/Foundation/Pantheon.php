<?php
/**
 * (c) Jackie Tao <jackie8tao@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Date: 18-11-29, Time: 下午5:39
 */

namespace Keer\Foundation;

use Keer\Container\Container;
use Keer\Foundation\Exception\FoundationException;

/**
 * 万物自此开始，由此而终结！
 * Class Pantheon
 * @package Keer\Foundation
 */
class Pantheon extends Container
{
    /** @var Pantheon 单例模式存储对象 */
    protected static $INSTANCE;

    /** @var string 应用的根目录 */
    protected $rootpath;

    /**
     * Pantheon constructor.
     * @param string $path
     * @throws FoundationException
     */
    private function __construct(string $path)
    {
        if (!$path) {
            throw new FoundationException('无效的应用程序根目录');
        }

        $this->rootpath = $path;
    }

    /**
     * 获取获取应用对象
     * @param string|null $path 应用的根目录
     * @return Pantheon
     * @throws FoundationException
     */
    public static function instance(string $path = null)
    {
        if (!static::$INSTANCE) {
            static::$INSTANCE = new Pantheon($path);
        }

        return static::$INSTANCE;
    }

    /**
     * 获取程序根目录路径
     * @return string 应用程序的根目录
     */
    public function rootpath() : string
    {
        return $this->rootpath;
    }
}