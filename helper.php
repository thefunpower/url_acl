<?php


/**
* 向角色中添加权限名
* url_acl_add_auth("管理员",'产品');
* url_acl_add_auth("管理员",['产品','产品列表']);
*/
function url_acl_add_auth($auth_name, $acl_title)
{
    global $_url_acl_add_auth;
    if(is_array($acl_title)) {
        foreach($acl_title as $title) {
            $_url_acl_add_auth[$auth_name][$title] = $title;
        }
    } else {
        $_url_acl_add_auth[$auth_name][$acl_title] = $acl_title;
    }
}
/**
* 检测角色是否有权限
*/
function url_acl($auth_name)
{
    if(is_array($auth_name)) {
        foreach($auth_name as $v) {
            if(!$list) {
                $list = get_url_acl_auth_urls($v);
            } else {
                $append = get_url_acl_auth_urls($v);
                $list = array_merge($list, $append);
            }
        }
    } else {
        $list = get_url_acl_auth_urls($auth_name);
    }
    if(!$list) {
        return false;
    }
    $uri = get_url_acl_request_uri();
    if(function_exists('do_action')) {
        $data = ['list' => $list,'uri' => $uri];
        do_action("acl.check", $data);
        if($data['res']) {
            return true;
        } else {
            return false;
        }
    }
    if($uri && in_array($uri, $list)) {
        return true;
    } else {
        return false;
    }
}
/**
* 取角色有的权限
* 返回可以访问的URL
*/
function get_url_acl_auth_urls($auth_name)
{
    global $_url_acl_list;
    $list = get_url_acl_auth_name($auth_name);
    if(!$list) {
        return ;
    } else {
        $urls = [];
        foreach($list as $k => $v) {
            $url = [];
            $arr = $_url_acl_list[$v];
            if(is_array($arr)) {
                foreach($arr as $v1) {
                    $url[] = $v1;
                }
            } else {
                $url =  $arr;
            }
            $urls[] = $url;
        }
        $list = [];
        foreach ($urls as $key => $v) {
            foreach($v as $v1) {
                $list[$v1] = $v1;
            }
        }
        return $list;
    }
}
/**
* 取角色拥有的ACL名称
*/
function get_url_acl_auth_name($auth_name)
{
    global $_url_acl_add_auth;
    if(!is_array($_url_acl_add_auth) || !isset($_url_acl_add_auth[$auth_name])) {
        return;
    }
    $list = $_url_acl_add_auth[$auth_name];
    return $list;
}


/**
* 把URL添加到权限中
*/
function url_acl_add($title, $url)
{
    global $_url_acl_list;
    if(is_array($url)) {
        foreach($url as $v) {
            $_url_acl_list[$title][] = $v;
        }
    } else {
        $_url_acl_list[$title][] = $url;
    }
}
/**
* 取请求URL，不包含?
*/
function get_url_acl_request_uri()
{
    $uri = $_SERVER['REQUEST_URI'];
    if(strpos($uri, '?') !== false) {
        $uri = substr($uri, 0, strpos($uri, '?'));
    }
    if(function_exists('do_action')) {
        do_action("acl.url", $uri);
    }
    return $uri;
}

/**
* 权限列表
*/
function get_url_acl()
{
    global $_url_acl_list;
    return $_url_acl_list;
}
