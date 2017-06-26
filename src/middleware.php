<?php
// Application middleware

$app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware($app,[
    new \Whoops\Handler\PrettyPageHandler()
]));
