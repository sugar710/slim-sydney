<?php
// DIC configuration

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$container = $app->getContainer();

// routes register
$container['routes'] = function ($c) use ($app) {
    return new \App\Router($app);
};

// middleware register
$container['middleware'] = function ($c) use ($app) {
    return new \App\Middleware($app);
};

// blade
$container["view"] = function ($c) {
    $settings = $c->get("settings")["blade"];
    $view = new \duncan3dc\Laravel\BladeInstance($settings["view_path"], $settings["cache_path"]);
    return $view;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// orm
$capsule = new \Illuminate\Database\Capsule\Manager();
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($c) use ($capsule) {
    return $capsule;
};

$container['schema'] = function ($c) {
    /** @var \Illuminate\Database\Capsule\Manager $db */
    $db = $c->get("db");
    $builder = $db->getConnection()->getSchemaBuilder();
    return $builder;
};

// guzzle http client
$container['guzzle'] = function ($c) {
    return new GuzzleHttp\Client([
        "timeout" => 60
    ]);
};

// flash
$container['flash'] = function ($c) {
    return new \Slim\Flash\Messages();
};

// session
$container['session'] = function ($c) {
    return new \SlimSession\Helper;
};

// 错误处理
$container['phpErrorHandler'] = function ($c) {
    return new \App\Handlers\PhpError($c);
};

// 异常处理
$container['errorHandler'] = function ($c) {
    return new \App\Handlers\Error($c);
};

// 404 处理
$container['notFoundHandler'] = function ($c) {
    return new \App\Handlers\NotFound($c);
};

/*// 控制器方法中去除req,res
$container['foundHandler'] = function () {
    return function (callable $callable, ServerRequestInterface $request, ResponseInterface $response, array $routeArguments) {
        foreach ($routeArguments as $k => $v) {
            $request = $request->withAttribute($k, $v);
        }
        return call_user_func($callable, $routeArguments);
    };
};*/

