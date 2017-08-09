<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * 验证管理后台是否登录
 *
 * Class VerifyAdminLogin
 * @package App\Middleware
 */
class VerifyAdminLoginMiddleware {

    public function __invoke(Request $req, Response $res, callable $next)
    {
        $adminUser = make("session")->get("admUser");
        if(empty($adminUser)) {
            return $res->withRedirect("/admin/login");
        }
        return $next($req, $res);
    }
}