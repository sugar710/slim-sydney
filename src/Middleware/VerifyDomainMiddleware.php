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
class VerifyDomainMiddleware {

    /**
     * 允许访问的域名
     * @var array
     */
    private $allowDomain = [];

    public function __construct($allowDomain = '')
    {
        if(is_array($allowDomain)) {
            $this->allowDomain = $allowDomain;
        } else if(is_string($allowDomain)) {
            $this->allowDomain = array_filter(explode(",", $allowDomain));
        }
    }

    public function __invoke(Request $req, Response $res, callable $next)
    {
        $host = $req->getUri()->getHost();
        if(!empty($this->allowDomain) && !in_array($host, $this->allowDomain)) {
            if($req->isXhr()) {
                return $res->withJson([
                    "status" => 0,
                    "info" => "非法操作"
                ],404);
            } else {
                $res->getBody()->write("非法操作");
                return $res->withStatus(404);
            }
        }
        return $next($req, $res);
    }
}