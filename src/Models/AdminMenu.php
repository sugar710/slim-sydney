<?php

namespace App\Models;

class AdminMenu extends Model {

    protected $table = "admin_menu";

    protected $guarded = [];

    /**
     * 菜单关联路由
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function router() {
        return $this->hasOne(AdminRouter::class, 'id', 'router_id');
    }

    /**
     * 获取层级数组
     */
    public static function levelMenu() {
        $list = self::orderBy("sort", "desc")->with(["router"])->orderBy("id", "asc")->get(["id", "pid", "name", "router_id"])->toArray();
        return levelArr($list, 0, 'pid');
    }
}