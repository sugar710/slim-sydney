<?php
namespace App;

use Slim\App;
use Slim\Middleware\Session;
use RKA\Middleware\IpAddress;
use Whoops\Handler\PrettyPageHandler;
use Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware;

/**
 * 中间件注册
 *
 * Class Middleware
 * @package App
 */
class Middleware
{
    protected $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * 系统中间件注册
     */
    public function register()
    {
        $this->app->add(new WhoopsMiddleware($this->app, [
            new PrettyPageHandler()
        ]));

        $this->app->add(new IpAddress(true, []));

        ini_set('session.save_path', realpath('../logs/sessions/'));
        $this->app->add(new Session([
            'name' => 'slim-sydney',
            'autorefresh' => true,
            'lifetime' => '1 hour',
            //'path' => '../logs/sessions',
        ]));

    }
}

