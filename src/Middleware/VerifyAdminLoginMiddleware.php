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
class VerifyAdminLoginMiddleware extends Middleware
{

    public function __invoke(Request $req, Response $res, callable $next)
    {
        $adminUser = $this->session->get("admUser");
        if (empty($adminUser)) {
            return $res->withRedirect("/admin/login?returnUrl=" . urlencode($req->getUri()->getPath()));
        }
        return $next($req, $res);
    }
}