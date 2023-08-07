# 基于URL的权限管理

# 添加权限

~~~
url_acl_add('产品列表','/index.php/goods');
url_acl_add('产品','/index.php/goods/add');
~~~

# 取权限信息

~~~
print_r(get_url_acl());
~~~

# 对角色赋予权限

~~~
url_acl_add_auth("管理员",'产品');
url_acl_add_auth("管理员",'产品列表');
~~~

# 查看角色可以访问的URL

~~~
$res = get_url_acl_auth_urls("管理员");
print_r($res);
~~~

# 检测是否有权限

~~~
print_r(url_acl("管理员"));
~~~

# 安装

在composer.json中添加
~~~
"thefunpower/url_acl": "dev-main" 
~~~




### 开源协议 

The [MIT](LICENSE) License (MIT)