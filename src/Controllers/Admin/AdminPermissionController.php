<?php

namespace App\Controllers\Admin;

/**
 * 权限管理
 *
 * Class AdminPermissionController
 * @package App\Controllers\Admin
 */
class AdminPermissionController extends BaseController {

    /**
     * 权限列表
     */
    public function index() {
        return $this->view->render("adm.permission.index", []);
    }


}