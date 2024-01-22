# 基于URL的权限管理

### 添加权限

~~~
url_acl_add('产品列表','/index.php/goods');
url_acl_add('产品','/index.php/goods/add');
~~~

### 取权限信息

~~~
print_r(get_url_acl());
~~~

### 对角色赋予权限

~~~
url_acl_add_auth("管理员",'产品');
url_acl_add_auth("管理员",'产品列表');
~~~

### 查看角色可以访问的URL

~~~
$res = get_url_acl_auth_urls("管理员");
print_r($res);
~~~

### 检测是否有权限

~~~
print_r(url_acl("管理员"));
~~~

### 在平台软件中使用
~~~

global $acl_config;

$acl_config['员工授权'] = [
	'管理'=>'/sys/acl/*', 
	'查寻'=>'/sys/acl/view', 
];


$acl_config['费用'] = [
	'管理'=>'/sys/expense/*',
	'查寻'=>'employee/user/*',
];

foreach($acl_config as $k=>$v){ 
	foreach($v as $k1=>$v1){
		url_acl_add($k.$k1,$v1);	
		url_acl_add_auth($k,$k.$k1);	
	}	 
} 
~~~


判断权限

~~~
add_action("acl.check", function (&$data) {
    $route = IRoute::get_action();
    $package = $route['package'];
    $module = $route['module'];
    $controller = $route['controller'];
    $action = $route['action'];
    $str = $module . '/' . $controller . '/' . $action;
    $str1 = $module . '/' . $controller . '/*';
    $list = $data['list']; 
    foreach($list as $v) {
        $a = substr($v, 0, 1);
        if($a == '/') {
            $v = substr($v, 1);
        }
        if($v == $str || $v == $str1) {
            $data['res'] = true;
            return;
        }
    }
    $data['res'] = false;
});
pr(url_acl(["员工授权",'费用'])); 
~~~

### 安装

在composer.json中添加
~~~
"thefunpower/url_acl": "dev-main" 
~~~




### 开源协议 
 
[Apache License 2.0](LICENSE)