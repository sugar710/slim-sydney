<?php
// Application middleware

$app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware($app,[
    new \Whoops\Handler\PrettyPageHandler()
]));

$app->add(new RKA\Middleware\IpAddress(true, []));

$app->add(new \Slim\Middleware\Session([
    'name' => 'slim-sydney',
    'autorefresh' => true,
    'lifetime' => '1 hour',
]));
