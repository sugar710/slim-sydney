<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * 路由域名限制
 *
 * Class VerifyDomainMiddleware
 * @package App\Middleware
 */
class VerifyDomainMiddleware
{

    /**
     * 允许访问的域名
     * @var array
     */
    private $allowDomain = [];

    public function __construct($allowDomain = '')
    {
        if (is_array($allowDomain)) {
            $this->allowDomain = $allowDomain;
        } else if (is_string($allowDomain)) {
            $this->allowDomain = array_filter(explode(",", $allowDomain));
        }
    }

    public function __invoke(Request $req, Response $res, callable $next)
    {
        $host = $req->getUri()->getHost();
        if (!$this->allow($host)) {
            return $this->reject($req, $res);
        }
        return $next($req, $res);
    }

    /**
     * 阻止请求
     *
     * @param Request $req
     * @param Response $res
     * @return mixed|static
     */
    private function reject(Request $req, Response $res)
    {
        if ($req->isXhr()) {
            return $res->withJson([
                "status" => 0,
                "info" => "非法操作",
            ], 404);
        }
        $res->getBody()->write("404 Not Found");
        return $res->withStatus(404);
    }

    /**
     * 是否通过
     *
     * @param $host
     * @return bool
     */
    public function allow($host)
    {
        return empty($this->allowDomain) || in_array($host, $this->allowDomain);
    }
}