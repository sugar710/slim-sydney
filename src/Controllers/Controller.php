<?php

namespace App\Controllers;

use Slim\Container;
use Slim\Http\Response;

/**
 * @property \duncan3dc\Laravel\BladeInstance view
 * @property \Slim\Flash\Messages flash
 * @property \Illuminate\Database\Capsule\Manager db
 * @property \SlimSession\Helper session
 * @property \Monolog\Logger logger
 */
class Controller
{
    protected $container;
    protected $req;
    protected $res;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __get($name)
    {
        if ($value = $this->container->get($name)) {
            return $value;
        }
        throw new \Exception($name . '不存在');
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
        $this->logger->info(print_r($json, true));
        if (is_array($status)) {
            $json = $status;
        } else {
            if (!empty($data)) {
                $json["data"] = $data;
            }
        }
        return (new Response())->withJson($json, 200, JSON_UNESCAPED_UNICODE);
    }
}