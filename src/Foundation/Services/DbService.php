<?php
/**
 * (c) Jackie Tao <jackie8tao@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Date: 19-2-20, Time: 上午3:00
 */

namespace Keer\Foundation\Services;

use Doctrine\DBAL\DriverManager;
use Keer\Container\ServiceProvider\GenericService;

/**
 * 数据库服务组件
 * Class DbService
 * @package Keer\Foundation\Services
 */
class DbService extends GenericService
{
    public function __construct()
    {
        $this->aliases = ['kdb'];
    }

    /**
     * 设置组件
     * @return void
     */
    protected function setup()
    {
        $platform = kConfig()->get('db.default');
        $connections = kConfig()->get('db.connections');

        $this->component = DriverManager::getConnection($connections[$platform]);
    }
}