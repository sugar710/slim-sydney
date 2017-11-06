<?php

namespace App\Middleware;

/**
 * 中间件
 *
 * Class Middleware
 * @property \Illuminate\Database\Capsule\Manager db
 * @property \Monolog\Logger logger
 * @property \SlimSession\Helper session
 * @package App\Middleware
 */
class Middleware
{

    public function __get($name)
    {
        return make($name);
    }
}