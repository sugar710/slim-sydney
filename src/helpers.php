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
function iAsset($path, $default = 'upload/default.png')
{
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
 * @throws \Interop\Container\Exception\ContainerException
 */
function admUrl($path, $query = [])
{
    $settings = make("settings")["admin"];

    $queryString = "";
    if (!empty($query)) {
        $q = $query;
        is_string($query) && parse_str($query, $q);
        $queryString = "?" . http_build_query($q);
    }

    if (!empty($settings["domain"])) {
        return '/' . ltrim($path, '/') . $queryString;
    }

    return '/' . ($settings['path'] ?: 'admin') . '/' . ltrim($path, '/') . $queryString;

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

/**
 * parse_str 反函数
 *
 * @param array $url_arr
 * @return string
 */
function http_build_url(array $url_arr)
{
    $new_url = $url_arr['scheme'] . "://" . $url_arr['host'];
    if (!empty($url_arr['port']))
        $new_url = $new_url . ":" . $url_arr['port'];
    if (isset($url_arr['path'])) {
        $new_url = $new_url . $url_arr['path'];
    }
    if (!empty($url_arr['query']))
        $new_url = $new_url . "?" . $url_arr['query'];
    if (!empty($url_arr['fragment']))
        $new_url = $new_url . "#" . $url_arr['fragment'];
    return $new_url;
}

/**
 * 生成guid
 *
 * @param string $prefix
 * @return string
 */
function guid($prefix = '')
{
    $chars = md5(uniqid(mt_rand(), true));
    $uuid = substr($chars, 0, 8) . '-';
    $uuid .= substr($chars, 8, 4) . '-';
    $uuid .= substr($chars, 12, 4) . '-';
    $uuid .= substr($chars, 16, 4) . '-';
    $uuid .= substr($chars, 20, 12);
    return $prefix . $uuid;
}

/**
 * url附加参数
 *
 * @param string $url
 * @param array $params
 * @return string
 */
function urlAppends($url = "", $params = [])
{
    $urlArr = parse_url($url);
    parse_str(isset($urlArr["query"]) ? $urlArr["query"] : "", $query);
    $query = array_merge($query, $params);
    $urlArr["query"] = http_build_query($query);
    return http_build_url($urlArr);
}

/**
 * 判断指定域名
 *
 * @param string $type
 * @param null $domain
 * @return bool
 */
function isDomain($type = "admin", $domain = null)
{
    $domain = $domain ?: env('HTTP_HOST', '');
    $domains = env(strtoupper($type) . "_DOMAIN", "");
    return in_array($domain, explode(",", $domains));
}

/**
 * 成功响应
 *
 * @param $message
 * @param $url
 * @return mixed
 * @throws \Interop\Container\Exception\ContainerException
 */
function responseReject($message, $url)
{
    flashReject(make("request")->getParams());
    flash("action.error", $message);
    return make("response")->withRedirect($url);
}

/**
 * 失败响应
 *
 * @param $message
 * @param $url
 * @return mixed
 * @throws \Interop\Container\Exception\ContainerException
 */
function responseResolve($message, $url)
{
    flash("action.success", $message);
    return make("response")->withRedirect($url);
}

/**
 * 闪存提交的数据
 *
 * @param $params
 * @throws \Interop\Container\Exception\ContainerException
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
 * @throws \Interop\Container\Exception\ContainerException
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
 * @throws \Interop\Container\Exception\ContainerException
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
 * @throws \Interop\Container\Exception\ContainerException
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
 * @throws \Interop\Container\Exception\ContainerException
 */
function logger($msg, $type = "info")
{
    make("logger")->{$type}($msg);
}

/**
 * 记录异常日志
 *
 * @param $msg
 * @param Exception $e
 * @throws \Interop\Container\Exception\ContainerException
 */
function loggerException($msg, \Exception $e)
{
    logger($msg . "\r\n" . $e->getMessage() . "\r\n" . $e->getTraceAsString(), "debug");
}

/**
 * 获取组件
 *
 * @param null $name
 * @return \App\Container|mixed
 * @throws \Interop\Container\Exception\ContainerException
 */
function make($name = null)
{
    return is_null($name) ? container() : container()->get($name);
}

/**
 * 获取容器
 *
 * @return \App\Container
 */
function container()
{
    return \App\Container::getInstance();
}