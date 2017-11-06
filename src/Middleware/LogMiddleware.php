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
    public function __invoke(Request $req, Response $res, callable $next)
    {
        $adminUser = $this->session->get("admUser");

        try {
            AdminLog::create([
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

        return $next($req, $res);
    }

}