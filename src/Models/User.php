<?php

namespace App\Models;

/**
 * 管理用户
 *
 * Class User
 * @package App\Models
 */
class User extends Model
{
    protected $table = "admin_user";
    protected $guarded = [];

    /**
     * 用户角色
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, 'admin_user_role', 'user_id', 'role_id');
    }

    /**
     * 用户路由
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function routers() {
        return $this->belongsToMany(AdminRouter::class, 'admin_user_router', 'user_id', 'router_id');
    }

    /**
     * 用户是否含用某角色
     *
     * @param $role
     * @return bool
     */
    public function isRole($role) {
        $slugs = $this->roles()->pluck("slug")->toArray();
        return in_array($role, $slugs);
    }

    /**
     * 当前用户是否有调用该路由的权限
     *
     * @param AdminRouter $router
     * @return bool
     */
    public function hasRouter(AdminRouter $router) {
        $routers = $this->routers()->pluck("router_id")->toArray();
        if (in_array($router->id, $routers)) {
            return true;
        }
        foreach($this->roles as $role) {
            if($role->hasRouter($router)) {
                return true;
            }
        }
        return false;
    }


}