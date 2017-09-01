<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * 验证程序安装中间件
 *
 * Class VerifyInstallMiddleware
 * @package App\Middleware
 */
class VerifyInstallMiddleware
{
    const INSTALL = true;

    const UNINSTALL = false;

    private $shouldInstall = true;

    private $installFile = __DIR__ . '/../../public/install.lock';

    public function __construct($shouldInstall = self::INSTALL)
    {
        $this->shouldInstall = $shouldInstall;
    }

    public function __invoke(Request $req, Response $res, callable $next)
    {
        // 需要安装 但 未安装
        if ($this->shouldInstall && !$this->isInstall()) {
            return $this->unInstallReject($req, $res);
        }

        // 不需要安装 但 已安装
        if (!$this->shouldInstall && $this->isInstall()) {
            return $this->installedReject($req, $res);
        }

        return $next($req, $res);
    }

    /**
     * 程序未安装提示
     *
     * @param Request $req
     * @param Response $res
     * @return static | mixed
     */
    private function unInstallReject(Request $req, Response $res)
    {
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

    /**
     * 程序已安装提示
     *
     * @param Request $req
     * @param Response $res
     * @return Response|static
     */
    private function installedReject(Request $req, Response $res)
    {
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

    /**
     * 判断程序是否安装
     *
     * @return bool
     */
    private function isInstall()
    {
        return is_file($this->installFile);
    }

}