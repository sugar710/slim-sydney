<?php

namespace App;

use Slim\App;
use App\Routes\Install;
use App\Routes\System;

/**
 * 路由注册
 *
 * Class Routes
 * @package App
 */
class Router
{
    /** @var App $app */
    protected $app;

    protected $routers = [
        Install::class,
        System::class,
    ];

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function register()
    {
        foreach ($this->routers as $router) {
            (new $router)->registerRouter($this->app);
        }
    }
}
