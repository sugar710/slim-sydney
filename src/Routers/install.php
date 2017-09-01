<?php

use App\Controllers\InstallController;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Middleware\VerifyInstallMiddleware;

//基础数据安装

$app->get("/install", function(Request $req, Response $res) {
    return $res->withRedirect("/install/welcome",301);
});

$app->group("/install", function() use ($app){

    $app->get("/", function(Request $req, Response $res){
        return $res->withRedirect('/install/welcome', 301);
    });

    $app->get("/welcome", InstallController::class . ':welcome');

    $app->post("/agree/verify", InstallController::class . ':agreeVerify');

    $app->get("/env", InstallController::class . ':env');

    $app->get("/database", InstallController::class . ':database');

    $app->post("/database/verify", InstallController::class . ':databaseVerify');

    $app->get("/account", InstallController::class . ':accountConf');

    $app->post("/account/verify", InstallController::class . ":accountVerify");

    $app->get("/ready/go", InstallController::class . ':doInstall');

})->add(new VerifyInstallMiddleware(VerifyInstallMiddleware::UNINSTALL));