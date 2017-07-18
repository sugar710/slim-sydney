<?php

namespace App\Controllers;

use Slim\Container;

/**
 * @property \duncan3dc\Laravel\BladeInstance view
 * @property \Slim\Flash\Messages flash
 * @property \Illuminate\Database\Capsule\Manager db
 * @property \SlimSession\Helper session
 */
class Controller {
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __get($name) {
        if($value = $this->container->get($name)) {
            return $value;
        }
        throw new \Exception($name . '不存在');
    }
}