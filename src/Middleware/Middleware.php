<?php

namespace App\Middleware;

/**
 * 中间件
 *
 * Class Middleware
 * @property \Illuminate\Database\Capsule\Manager db
 * @property \Monolog\Logger logger
 * @property \SlimSession\Helper session
 * @property \GuzzleHttp\Client guzzle
 * @package App\Middleware
 */
class Middleware
{

    /**
     * @param $name
     * @return \App\Container|mixed
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __get($name)
    {
        return make($name);
    }
}