<?php
// DIC configuration

$container = $app->getContainer();

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
$container['db'] = function ($c) {
    $capsule = new \Illuminate\Database\Capsule\Manager();
    $capsule->addConnection($c['settings']['db']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    return $capsule;
};

// guzzle http client
$container['guzzle'] = function ($c) {
    return new GuzzleHttp\Client([
        "timeout" => 60
    ]);
};

$container['schema'] = function ($c) {
    /**
     * @var \Illuminate\Database\Capsule\Manager $db
     */
    $db = $c->get("db");
    $builder = $db->getConnection()->getSchemaBuilder();
    return $builder;
};

// flash
$container['flash'] = function ($c) {
    return new \Slim\Flash\Messages();
};

// session
$container['session'] = function ($c) {
    return new \SlimSession\Helper;
};

$container["req"] = $container["request"];

$container["res"] = $container["response"];

