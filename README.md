# bbs
使用laravel开发的论坛程序，类似phphub

这样一个程序，将分不同的阶段来开发。每个阶段使用不同的分支来记录对应的过程。

## 第一阶段
* 实现Post的增删改查
* Comment的增删改查
* Comment与Post的联表查询

## 第二阶段

* 加入user
* 加入Authentication
    * 增加用户注册页面
    * 增加用户登陆页面
* 增删改查Post需要登陆
* 增删改查Comment需要登陆
* 仅能修改自己的Comment(Comment暂时不做修改功能吧，懒!）
* 仅能删除自己的Comment


## 第三阶段

* 更新表结构，与phphub类似
* 使用boostrap结合phphub更新前端样式
* posts如下方式索引：
    * 按照category_id检索
    * 按照：活跃、精华、投票、最近、零回复
* 采用MD编辑器编辑内容
* 用户中心功能
* 点赞功能

## 第四阶段

* 前端页面重构
    * 首页
    * 登陆页
    * 注册页
    * post列表页
    * post单页
    * 个人中心首页
    * 个人中心首页列表页
* 消息提醒


# 常用断言总结

## 未分类
* assertEquals(mixed $expected, mixed $actual),判断两个值是否全等；


## 数据库相关

* seeInDatabase(string $table, array $data, $connection = null)，判断数据存在数据库中。
* notSeeInDatabase(string $table, array $data, $connection = null)，判断数据不存在数据库中。
* seed($class = 'DatabaseSeeder')，运行数据库seed


## 路由相关

* visit($uri)，访问某个地址
* visitRoute($route, $parameters = [])，根据路由名称访问
* seePageIs($uri)，当前页面是否与$uri页面相同
* seeRouteIs($route, $parameters = [])

## 页面元素相关

* type($text, $element)，给$element指定的input表单输入$text内容
* press($buttonText)，提交使用button的表单
* submitForm($buttonText, $inputs = [], $uploads = []),提交表单

## 认证相关

* seeIsAuthenticated($guard = null)，用户是否认证
