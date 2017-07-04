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

function flash($key, $msg = null){
    //我想在这里拿到 slim-flash组件
}