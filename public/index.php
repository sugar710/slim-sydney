<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

date_default_timezone_set("Asia/Shanghai");

require __DIR__ . '/../vendor/autoload.php';

session_start();

if(is_file(__DIR__ . '/../config.env')) {
    $dotenv = new \Dotenv\Dotenv(__DIR__ . '/../', 'config.env');
    $dotenv->load();
}

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';

$container = new \App\Container($settings);

$app = new \Slim\App($container);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();
