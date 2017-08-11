<?php
// Routes
use Slim\Http\Request;
use Slim\Http\Response;
use App\Controllers\Admin\AuthController;
use App\Controllers\Admin\HomeController;
use App\Controllers\InstallController;
use App\Controllers\Admin\AdminPermissionController;
use App\Middleware\VerifyAdminLoginMiddleware;

$app->get('/admin/login', AuthController::class . ':login');

$app->post('/admin/login', AuthController::class . ':doLogin');

$app->get('/admin/logout', AuthController::class . ':logout');

$app->group("/admin", function() use ($app) {
    $app->get("/home", HomeController::class . ':home');

    //权限管理
    $app->get('/permission', AdminPermissionController::class . ':index')->setName("admin.permission");
    $app->get('/permission/data', AdminPermissionController::class . ':data');
    $app->get('/permission/delete', AdminPermissionController::class . ':doDelete');
    $app->post('/permission', AdminPermissionController::class . ':save');

})->add(VerifyAdminLoginMiddleware::class);

$app->get("/install", function(Request $req, Response $res) {
    return $res->withRedirect("/install/welcome");
});

$app->group("/install", function() use ($app){

    $app->get("/", function(Request $req, Response $res){
        return $res->withRedirect('/install/welcome');
    });

   $app->get("/welcome", InstallController::class . ':welcome');

   $app->post("/agree/verify", InstallController::class . ':agreeVerify');

   $app->get("/env", InstallController::class . ':env');

   $app->get("/database", InstallController::class . ':database');

   $app->post("/database/verify", InstallController::class . ':databaseVerify');

   $app->get("/account", InstallController::class . ':accountConf');

   $app->post("/account/verify", InstallController::class . ":accountVerify");

   $app->get("/ready/go", InstallController::class . ':doInstall');

});