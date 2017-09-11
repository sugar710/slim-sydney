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
 * 生成上传文件访问地址
 *
 * @param $path
 * @param string $default
 * @return string
 */
function iAsset($path, $default = 'upload/default.png') {
    return '/' . (!empty($path) ? $path : $default);
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
 * 管理后台访问地址生成
 *
 * @param string $path
 * @param array $query 查询参数
 * @return string
 */
function admUrl($path, $query = [])
{
    $admPath = make("settings")["admin"]["path"] ?: "admin";
    $queryString = "";
    if (!empty($query)) {
        $q = [];
        if (is_string($query)) {
            parse_str($query, $q);
        } else {
            $q = $query;
        }
        $queryString = "?" . http_build_query($q);
    }
    return '/' . $admPath . '/' . ltrim($path, '/') . $queryString;
}

/**
 * 获取子孙数组
 *
 * @param array $arr 数组源
 * @param int $id
 * @param int $lev
 * @param string $pidKey
 * @return array
 */
function subtree($arr, $id = 0, $lev = 0, $pidKey = 'parent_id')
{
    $result = array();
    foreach ($arr as $item) {
        if (!is_array($item)) {
            $item = (array)$item;
        }
        if ($item[$pidKey] == $id) {
            $item['lev'] = $lev;
            $result[] = $item;
            $result = array_merge($result, subtree($arr, $item['id'], $lev + 1, $pidKey));
        }
    }
    return $result;
}

/**
 * 将数组格式化为多组数组
 *
 * @param array $arr 原始数组
 * @param int $id
 * @param string $relIndex 关联索引
 * @return array
 */
function levelArr(array $arr, $id = 0, $relIndex = 'parent_id')
{
    $result = [];
    foreach ($arr as $item) {
        if (!is_array($item)) {
            $item = (array)$item;
        }
        if ($item[$relIndex] == $id) {
            $item["items"] = levelArr($arr, $item["id"], $relIndex);
            if (empty($item["items"])) {
                unset($item["items"]);
            }
            $result[] = $item;
        }
    }
    return $result;
}

if (!function_exists('env')) {
    /**
     * 获取ENV配置项
     *
     * @param $key
     * @param string $default
     * @return string $value
     */
    function env($key, $default = '')
    {
        $value = getenv($key);
        return $value === false ? $default : $value;
    }
}

function responseReject($message, $url)
{
    flashReject(make("request")->getParams());
    flash("action.error", $message);
    return make("response")->withRedirect($url);
}

function responseResolve($message, $url)
{
    flash("action.success", $message);
    return make("response")->withRedirect($url);
}

/**
 * 闪存提交的数据
 *
 * @param $params
 */
function flashReject($params)
{
    $params = $params ?: [];
    flash("req.is_back", "T");
    flash("req.data", json_encode($params));
}

/**
 * 获取上次输入的值
 *
 * @param string $key
 * @param null $default
 * @return null
 */
function old($key, $default = null)
{
    $is_back = flash("req.is_back");
    if (empty($key) || $is_back != "T") {
        return $default;
    }
    $data = json_decode(flash("req.data") ?: "[]", true);
    return isset($data[$key]) ? $data[$key] : $default;
}

/**
 * 获取及设置flash
 *
 * @param $key
 * @param null $msg
 * @return mixed
 */
function flash($key, $msg = null)
{
    $flash = make("flash");
    if (is_null($msg)) {
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
function session($key, $default = null)
{
    $session = make("session");
    if (is_string($key)) {
        return $session->get($key, $default);
    } else if (is_array($key)) {
        foreach ($key as $sk => $sv) {
            $session->set($sk, $sv);
        }
        return true;
    }
}

/**
 * 记录日志
 *
 * @param string $msg 日志内容
 * @param string $type 日志类型
 */
function logger($msg, $type = "info") {
    make("logger")->{$type}($msg);
}

/**
 * 获取组件
 *
 * @param null $name
 * @return \App\Container|mixed|null|static
 */
function make($name = null)
{
    if (is_null($name)) {
        return container();
    }
    return container()->get($name);
}

/**
 * 获取容器
 *
 * @return \App\Container|null|static
 */
function container()
{
    return \App\Container::getInstance();
}