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
路由部分使用[Fast-Route](https://github.com/nikic/FastRoute)组件，详细文档可以
参考其帮助页面。

#### 便捷功能
Keer框架提供了一些函数直接使用框架的基础组件功能。相关方法为：

- app 获取系统对象
- klog 获取系统日志组件
- kconfig 获取系统配置组件
- kroutes 获取系统路由组件
