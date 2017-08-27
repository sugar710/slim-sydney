<?php
// Routes
use Slim\Http\Request;
use Slim\Http\Response;
use App\Controllers\Admin\AuthController;
use App\Controllers\Admin\HomeController;
use App\Controllers\Admin\AdminPermissionController;
use App\Controllers\Admin\AdminRoleController;
use App\Controllers\Admin\AdminRouterController;
use App\Middleware\VerifyAdminLoginMiddleware;
use App\Middleware\VerifyDomainMiddleware;
use App\Middleware\VerifyInstallMiddleware;

$adminDomain = env("ADMIN_DOMAIN", '');

$app->get('/admin', function (Request $req, Response $res) {
    return $res->withRedirect("/admin/home", 301);
});

$app->group("/admin", function () use ($app) {

    $app->get('/login', AuthController::class . ':login');

    $app->post('/login', AuthController::class . ':doLogin');

    $app->get('/logout', AuthController::class . ':logout');

    $app->group("", function () use ($app) {
        $app->get("/home", HomeController::class . ':home');

        //权限管理
        $app->get('/permission', AdminPermissionController::class . ':index')->setName("admin.permission");
        $app->get('/permission/data', AdminPermissionController::class . ':data');
        $app->get('/permission/delete', AdminPermissionController::class . ':doDelete');
        $app->post('/permission', AdminPermissionController::class . ':save');

        //角色管理
        $app->get('/role', AdminRoleController::class . ':index')->setName("admin.role");
        $app->get('/role/data', AdminRoleController::class . ':data');
        $app->get('/role/delete', AdminRoleController::class . ':doDelete');
        $app->post('/role', AdminRoleController::class . ':save');

        //路由表管理
        $app->get('/router', AdminRouterController::class . ':index')->setName('admin.router');
        $app->get('/router/data', AdminRouterController::class . ':data');
        $app->get('/router/delete', AdminRouterController::class . ':doDelete');
        $app->post('/router', AdminRouterController::class . ':save');

    })->add(VerifyAdminLoginMiddleware::class);

})->add(new VerifyInstallMiddleware(true))->add(new VerifyDomainMiddleware($adminDomain));

require __DIR__ . '/Routers/install.php';