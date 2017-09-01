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

    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, 'admin_user_role', 'user_id', 'role_id');
    }


}