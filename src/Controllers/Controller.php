<?php

namespace App\Controllers;

use Slim\Container;
use Slim\Exception\ContainerException;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * @property \duncan3dc\Laravel\BladeInstance view
 * @property \Slim\Flash\Messages flash
 * @property \Illuminate\Database\Capsule\Manager db
 * @property \SlimSession\Helper session
 * @property \Monolog\Logger logger
 * @property \App\Models\Model $model
 * @property \Illuminate\Database\Schema\Builder schema
 * @property \Slim\Http\Request req
 * @property \Slim\Http\Response res
 * @property \Slim\Router router
 */
class Controller
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        if ($name == "model" && !empty($this->modelName)) {
            return new $this->modelName;
        }

        $name = $name == "req" ? "request" : $name;
        $name = $name == "res" ? "response" : $name;

        try {
            return $this->container->get($name);
        } catch (\Interop\Container\Exception\ContainerException $e) {
            $this->logException($this->req, $e);
            throw $e;
        }
    }

    /**
     * @param string $tableName
     * @return \Illuminate\Database\Query\Builder
     */
    public function table($tableName)
    {
        return $this->db->table($tableName);
    }

    /**
     * 项目统一JSON数据返回
     *
     * @param int $status
     * @param string $info
     * @param array $data
     * @return Response
     */
    public function jsonTip($status = 1, $info = "OK", $data = [])
    {
        $json = compact("status", "info");
        if (is_array($status)) {
            $json = $status;
        } else {
            if (!empty($data)) {
                $json["data"] = $data;
            }
        }
        $this->logger->info(print_r($json, true));
        return (new Response())->withJson($json, 200, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 操作成功响应
     *
     * @param $message
     * @param $url
     * @return mixed
     */
    public function resolve($message, $url)
    {
        return responseResolve($message, $url);
    }

    /**
     * 操作失败响应
     *
     * @param $message
     * @param $url
     * @return mixed
     */
    public function reject($message, $url)
    {
        return responseReject($message, $url);
    }

    /**
     * 获取返回地址
     *
     * @param $fallback
     * @return string
     */
    protected function backUrl($fallback = '/')
    {
        $urls = $this->req->getHeader("HTTP_REFERER");
        return $urls ? array_first($urls) : admUrl($fallback);
    }

    /**
     * 记录错误信息
     *
     * @param Request $req
     * @param \Exception $e
     */
    public function logException(Request $req, \Exception $e)
    {
        $this->logger->info($req->getMethod() . " " . $req->getUri()->getPath() . "\n" . $e->getMessage() . "\n" . $e->getTraceAsString());
    }
}