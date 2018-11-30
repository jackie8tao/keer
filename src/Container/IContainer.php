<?php

namespace Keer\Container;

/**
 * 容器接口
 * Interface IContainer
 * @package Keer\Container
 */
interface IContainer
{
    /**
     * 向容器中注册对象
     * @param string $alias , 对象名称
     * @param null $class , 依赖值，默认为空
     * @param array $parameters, 依赖所需要的参数
     */
    public function register(string $alias, $class = null, array $parameters = null);

    /**
     * 从容器中解析出指定对象
     * @param string $name, 对象名称
     * @return mixed
     */
    public function take(string $name);
}