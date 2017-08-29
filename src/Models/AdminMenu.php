<?php

namespace App\Models;

class AdminMenu extends Model {

    protected $table = "admin_menu";

    protected $guarded = [];

    public function router() {
        return $this->hasOne(AdminRouter::class, 'router_id', 'id');
    }
}