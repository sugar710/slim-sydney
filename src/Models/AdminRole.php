<?php

namespace App\Models;

/**
 * 角色管理
 *
 * Class AdminRole
 * @package App\Models
 */
class AdminRole extends Model
{

    protected $table = "admin_role";
    protected $guarded = [];

    /**
     * 角色含用的路由权限
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function routers()
    {
        return $this->belongsToMany(AdminRouter::class, 'admin_role_router', 'role_id', 'router_id');
    }

    /**
     * 角色是否含用某权限
     *
     * @param AdminRouter $router
     * @return bool
     */
    public function hasRouter(AdminRouter $router) {
        $routers = $this->routers()->pluck("router_id")->toArray();
        return in_array($router->id, $routers);
    }

}