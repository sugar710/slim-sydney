<?php

namespace App\Controllers\Admin;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * 权限管理
 *
 * Class AdminPermissionController
 * @package App\Controllers\Admin
 */
class AdminPermissionController extends BaseController {

    /**
     * 权限列表
     *
     * @param Request $req
     * @param Response $res
     * @return string
     */
    public function index(Request $req, Response $res) {
        return $this->view->render("adm.authority.permission.index", []);
    }


}