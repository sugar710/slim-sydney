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

    public function routers()
    {
        return $this->belongsToMany(AdminRouter::class, 'admin_role_router', 'role_id', 'router_id');
    }

}