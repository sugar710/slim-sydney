<?php
return [
    'settings' => [
        'debug' => false,
        'displayErrorDetails' => false, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // blade settings
        'blade' => [
            'view_path' => __DIR__ . '/../templates/',
            'cache_path' => __DIR__ . '/../caches/templates/'
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        'db' => [
            'driver' => 'mysql',
            'host' => env("DB_HOST","127.0.0.1"),
            'database' => env("DB_NAME", ""),
            'username' => env("DB_USER", "root"),
            'password' => env("DB_PASS", "root"),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ],
        'admin' => [
            'path' => 'admin', // 无domain配置时生效
            'domain' => env('ADMIN_DOMAIN', '')
        ]
    ],
];
