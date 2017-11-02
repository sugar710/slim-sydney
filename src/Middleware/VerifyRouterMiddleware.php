<?php

namespace App\Middleware;

use App\Models\AdminRouter;
use App\Models\User;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * 验证路由中间件
 *
 * Class VerifyRouterMiddleware
 * @package App\Middleware
 */
class VerifyRouterMiddleware
{
    private $adminUser;

    public function __construct()
    {
        $info = make("session")->get("admUser");
        $this->adminUser = User::find($info->id);
    }

    public function __invoke(Request $req, Response $res, callable $next)
    {
        $path = $req->getUri()->getPath();
        $method = $req->getMethod();
        if (!$router = $this->getRouter($path, $method)) {
            logger('未加入权限验证路由');
            return $next($req, $res);
        }
        if ($this->adminUser->isRole('root') || $this->adminUser->id === 1) {
            logger("超管直接跳转");
            return $next($req, $res);
        }
        if ($this->adminUser->hasRouter($router)) {
            logger("用户有权限");
            return $next($req, $res);
        }

        if ($req->isXhr()) {
            return $res->withJson(["status" => 0, "info" => "非法操作"], 401);
        } else {
            return $res->withStatus(401)->write("401 Unauthorized");
        }
    }

    /**
     * 获取路由信息
     *
     * @param $router
     * @param string $method
     * @return AdminRouter $info
     */
    private function getRouter($router, $method = "GET")
    {
        $router = str_replace("/admin/", "/", $router);
        $info = AdminRouter::where("method", $method)->where("path", $router)->first();
        return $info;
    }
}