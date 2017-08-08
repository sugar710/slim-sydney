<?php

namespace App\Controllers\Admin;

use App\Models\AdminPermission;
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
        $list = AdminPermission::all();
        $data = [
            "list" => $list
        ];
        return $this->view->render("adm.authority.permission.index", $data);
    }

    /**
     * 创建/修改 权限
     *
     * @param Request $req
     * @param Response $res
     * @return string
     */
    public function data(Request $req, Response $res) {
        $data = [];
        $id = $req->getParam("id", 0);
        if(!empty($id)) {
            $info = AdminPermission::find($id);
            $data["info"] = $info;
        }
        return $this->view->render("adm.authority.permission.data", $data);
    }

    /**
     * 保存提交内容
     *
     * @param Request $req
     * @param Response $res
     * @return mixed
     */
    public function save(Request $req, Response $res) {
        $id = $req->getParam("id", 0);
        if(is_numeric($id) && $id > 0) {
            return $this->doUpdate($req, $res);
        } else {
            return $this->doCreate($req, $res);
        }
    }

    /**
     * 创建数据
     *
     * @param Request $req
     * @param Response $res
     * @return mixed
     */
    protected function doCreate(Request $req, Response $res) {
        $result = AdminPermission::create([
            "name" => $req->getParam("name", ""),
            "slug" => $req->getParam("slug", "")
        ]);
        if(false && $result !== false) {
            flash("action.success", "数据保存成功");
            return $res->withRedirect(admUrl('/permission'));
        } else {
            flash("action.error", "数据保存失败请重试");
            return $res->withRedirect(admUrl('/permission/data'));
        }
    }

    /**
     * 更新数据
     *
     * @param Request $req
     * @param Response $res
     * @return mixed
     */
    protected function doUpdate(Request $req, Response $res) {
        $id = $req->getParam("id", 0);
        $result = AdminPermission::where("id", $id)->update([
            "name" => $req->getParam("name", ""),
            "slug" => $req->getParam("slug", "")
        ]);
        if($result !== false) {
            flash("action.success", "数据更新成功");
            return $res->withRedirect(admUrl("/permission"));
        } else {
            flash("action.error", "数据更新失败请重试");
            return $res->withRedirect(admin("/permission/data?id=" . $id));
        }
    }


}