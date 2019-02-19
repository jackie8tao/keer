### Keer Web开发框架
Keer开发框架是一个简单，快速的PHP Web开发框架，致力与API系统开发。为了追求框架的简洁，
Keer仅仅实现了基础容器、路由和MVC结构。

#### 容器部分
容器部分实现了对象的注册，依赖的自动解析和注入。使用形式如下：

```php 

// 别名 + 类名 + 参数
$container->register('foo', Foo::class, 
    ['name'=>'jackie', 'age'=> 15]
);

// 类名 + 参数
$container->register(Foo::class, ['name' => 'jackie', 'age' = 15]);

// 别名 + 对象
$container->register('foo', new Foo());

// 别名 + 闭包
$container->register('foo', function(){
    return new Foo;
});

```

Keer框架中的容器目前支持类名，闭包和对象三种形式，且依赖可以递归解析。

#### 路由部分
路由部分使用[Fast-Route](https://github.com/nikic/FastRoute)组件，框架仅对其
做了相关简化。使用方式如下：

```php

kroutes()->addRoute("GET", "/", "App\\Controller\\IndexController@index");

kroutes()->addGroup("/demo", function(\FastRoute\RouteCollector $r){
    $r->addRoute("GET", "/config", "App\\Controller\\IndexController@config");
    $r->addRoute("GET", "/db", "App\\Controller\\IndexController@db");
    $r->addRoute("GET", "/routes", "App\\Controller\\IndexController@routes");
    $r->addRoute("GET", "/redirect", "App\\Controller\\IndexController@redt");
});

```

> 需要注意的是，这里的控制器仅支持**类名@方法**的形式，更加详细的用法参考[Fast-Route官方文档](https://github.com/nikic/FastRoute)

#### 便捷功能
Keer框架提供了一些函数直接使用框架的基础组件功能。相关方法为：

- kApp 获取系统对象
- kLog 获取系统日志组件
- kConfig 获取系统配置组件
- kRoutes 获取系统路由组件
- kDb 数据库操作组件

#### 后续开发计划

1. 第三方组件接口统一，简化相关功能，方便开发者使用。
2. 添加缓存组件和系统事件机制。
