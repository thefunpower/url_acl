<?php 
 
/**
* 向角色中添加权限名
* url_acl_add_auth("管理员",'产品');
* url_acl_add_auth("管理员",['产品','产品列表']);
*/
function url_acl_add_auth($auth_name,$acl_title){
	global $_url_acl_add_auth;
	if(is_array($acl_title)){
		foreach($acl_title as $title){
			$_url_acl_add_auth[$auth_name][$title] = $title;
		}
	}else{
		$_url_acl_add_auth[$auth_name][$acl_title] = $acl_title;	
	}	
}
/**
* 检测角色是否有权限
*/
function url_acl($auth_name){
	$list = get_url_acl_auth_urls($auth_name);
	if(!$list){
		return false;
	}
	$uri = get_url_acl_request_uri();
	if($uri && in_array($uri,$list)){
		return true;
	}else{
		return false;
	}
}
/**
* 取角色有的权限
* 返回可以访问的URL
*/
function get_url_acl_auth_urls($auth_name){ 
	global $_url_acl_list; 
	$list = get_url_acl_auth_name($auth_name);
	if(!$list){
		return ;
	}else{
		$urls = [];
		foreach($list as $k=>$v){ 
			$urls[] = $_url_acl_list[$v]; 
		}
		return $urls;
	}
}
/**
* 取角色拥有的ACL名称
*/
function get_url_acl_auth_name($auth_name){
	global $_url_acl_add_auth; 
	if(!is_array($_url_acl_add_auth) || !isset($_url_acl_add_auth[$auth_name])){
		return;
	}
	$list = $_url_acl_add_auth[$auth_name];
	return $list;
}


/**
* 把URL添加到权限中
*/
function url_acl_add($title,$url){
	global $_url_acl_list;
	$_url_acl_list[$title] = $url;
}
/**
* 取请求URL，不包含?
*/
function get_url_acl_request_uri(){
	$uri = $_SERVER['REQUEST_URI'];
	if(!$uri){
		echo 'REQUEST_URI not in _SERVER';exit;
	}
	if(strpos($uri,'?')!==false){
		$uri = substr($uri,0,strpos($uri,'?'));
	}
	return $uri;
}

/**
* 权限列表
*/
function get_url_acl(){
	global $_url_acl_list;
	return $_url_acl_list;
}