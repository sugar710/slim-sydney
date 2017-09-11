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


}