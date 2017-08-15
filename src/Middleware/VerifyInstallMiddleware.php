<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * 验证程序是否已安装
 *
 * Class VerifyInstallMiddleware
 * @package App\Middleware
 */
class VerifyInstallMiddleware
{
    private $shouldInstall = true;

    public function __construct($shouldInstall = true)
    {
        $this->shouldInstall = $shouldInstall;
    }

    public function __invoke(Request $req, Response $res, callable $next)
    {
        $lockFilePath = __DIR__ . '/../../public/install.lock';
        $isFile = is_file($lockFilePath);
        if ($this->shouldInstall && !$isFile) {
            if ($req->isXhr()) {
                return $res->withJson([
                    "status" => 0,
                    "info" => "程序未成功安装",
                    "data" => [
                        "url" => url('/install')
                    ]
                ]);
            } else {
                return $res->withRedirect(url('/install'));
            }
        }
        if (!$this->shouldInstall && $isFile) {
            if ($req->isXhr()) {
                return $res->withJson([
                    "status" => 0,
                    "info" => "程序已安装，无需重复安装"
                ]);
            } else {
                $res->getBody()->write("程序已安装，无需重复安装");
                return $res;
            }
        }
        return $next($req, $res);
    }

}