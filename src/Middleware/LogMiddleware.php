<?php

namespace App\Middleware;

use App\Models\AdminLog;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * 日志记录中间件
 *
 * Class LogMiddleware
 * @package App\Middleware
 */
class LogMiddleware extends Middleware
{
    /** @var Request $req */
    protected $req;

    public function __invoke(Request $req, Response $res, callable $next)
    {
        $this->req = $req;

        $adminUser = $this->session->get("admUser");

        $log = null;

        try {
            $log = AdminLog::create([
                "user_id" => $adminUser ? $adminUser->id : 0,
                "method" => $req->getMethod(),
                "path" => $req->getUri()->getPath(),
                "ip" => $req->getAttribute("ip_address", "0.0.0.0"),
                "input" => json_encode($req->getParams(), JSON_UNESCAPED_UNICODE),
            ]);
        } catch (\Exception $e) {
            $this->logger->info($e->getMessage());
            $this->logger->info($e->getTraceAsString());
        }

        $res = $next($req, $res);

        $this->logReplace($log);

        return $res;
    }

    /**
     * 判断是否为登录操作
     *
     * @param null $path
     * @return bool
     */
    private function isLoginAction($path = null)
    {
        $this->logger->info("req - path:" . $this->req->getUri()->getPath());
        $path = $path ?: $this->req->getUri()->getPath();
        return $path == "/admin/login" && $this->req->isPost();
    }

    /**
     * 更新日志信息
     *
     * @param AdminLog $log
     */
    private function logReplace(AdminLog $log)
    {
        if (!$this->isLoginAction()) {
            return;
        }
        $adminUser = $this->session->get("admUser");
        if (!empty($adminUser) && !empty($log)) {
            $log->input = json_encode(
                array_merge($this->req->getParams(), ["password" => "******"]),
                JSON_UNESCAPED_UNICODE);
            $log->save();
        }
    }

}