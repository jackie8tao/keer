<?php
/**
 * (c) Jackie Tao <jackie8tao@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Date: 19-2-17, Time: 下午10:53
 */

namespace Keer\Foundation\Services;

use Keer\Container\ServiceProvider\GenericService;
use Noodlehaus\Config;

/**
 * 配置读取组件
 * Class ConfigService
 * @package Keer\Foundation\Services
 */
class ConfigService extends GenericService
{
    public function __construct()
    {
        $this->aliases = ['kconfig'];
        $this->component = new Config(app()->configPath());
    }

    /**
     * 设置组件
     * @return mixed
     */
    protected function setup()
    {
        return;
    }
}