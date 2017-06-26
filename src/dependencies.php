<?php
// DIC configuration

$container = $app->getContainer();

// blade
$container["view"] = function($c) {
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

// flash
$container['flash'] = function($c) {
    return new \Slim\Flash\Messages();
};
