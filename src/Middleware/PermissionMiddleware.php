<?php

namespace App\Middleware;

use App\Models\User;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * 权限中间件
 *
 * Class PermissionMiddleware
 * @package App\Middleware
 */
class PermissionMiddleware
{
    private $adminUser;
    private $method;
    private $role;

    public function __construct($method, $role)
    {
        make("db");
        $info = make("session")->get("admUser");
        $this->adminUser = User::find($info->id);
        $this->method = $method;
        $this->role = array_filter(explode(",", $role));
    }

    public function __invoke(Request $req, Response $res, callable $next)
    {
        if ($this->adminUser->isRole('root')) {
            return $next($req, $res);
        }

        $isAllow = $this->{$this->method}($this->role);

        if($isAllow) {
            return $next($req, $res);
        }

        if($req->isXhr()) {
            return $res->withJson(["status" => 0, "info" => "401 Unauthorized"], 401);
        } else {
            return $res->withStatus(401)->write("401 Unauthorized");
        }
    }

    /**
     * 允许角色访问
     *
     * @param array $roles
     * @return bool
     */
    public function allow(array $roles)
    {
        $slugs = $this->adminUser->roles()->pluck("slug")->toArray();
        foreach($roles as $role) {
            if(in_array($role, $slugs)) {
                return true;
            }
        }
        return false;
    }

    /**
     * 阻止角色访问
     *
     * @param array $roles
     * @return bool
     */
    public function deny(array $roles)
    {
        $slugs = $this->adminUser->roles()->pluck("slug")->toArray();
        foreach($roles as $role) {
            if(in_array($role, $slugs)) {
                return false;
            }
        }
        return true;
    }

}