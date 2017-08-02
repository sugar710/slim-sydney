<?php

/**
 * 静态文件获取
 *
 * @param $path
 * @return string
 */
function asset($path)
{
    return '/static/' . ltrim($path, '/');
}

/**
 * 管理后台静态文件获取
 *
 * @param $path
 * @return string
 */
function admAsset($path)
{
    return asset('adminLte/' . $path);
}

/**
 * 生成地址
 *
 * @param $path
 * @return string
 */
function url($path)
{
    return '/' . ltrim($path, '/');
}

/**
 * 获取及设置flash
 *
 * @param $key
 * @param null $msg
 * @return mixed
 */
function flash($key, $msg = null){
    $flash = make("flash");
    if(is_null($msg)) {
        return array_first($flash->getMessage($key));
    }
    return $flash->addMessage($key, $msg);
}

/**
 * 获取及设置session
 *
 * @param $key
 * @param null $default
 * @return bool|mixed
 */
function session($key, $default = null) {
    $session = make("session");
    if(is_string($key)) {
        return $session->get($key, $default);
    } else if(is_array($key)) {
        foreach($key as $sk => $sv) {
            $session->set($sk, $sv);
        }
        return true;
    }
}

/**
 * 获取组件
 *
 * @param null $name
 * @return \App\Container|mixed|null|static
 */
function make($name = null) {
    if(is_null($name)) {
        return container();
    }
    return container()->get($name);
}

/**
 * 获取容器
 *
 * @return \App\Container|null|static
 */
function container() {
    return \App\Container::getInstance();
}