<?php

namespace App\Controllers\Admin;

use App\Models\AdminPermission;
use App\Models\Model;
use App\Utils\Paginate;
use Slim\Exception\SlimException;
use Slim\Http\Request;
use Slim\Http\Response;
use Webmozart\Assert\Assert;

/**
 * 权限管理
 *
 * Class AdminPermissionController
 * @package App\Controllers\Admin
 */
class AdminPermissionController extends BaseController
{

    protected $viewFolder = 'adm.authority';

    /**
     * 权限列表
     *
     * @param Request $req
     * @param Response $res
     * @return string
     */
    public function index(Request $req, Response $res)
    {
        $size = 20;
        $page = $req->getParam("page", 1);
        $page = $page > 0 ? $page : 1;

        $query = $this->table("admin_permission");
        $count = $query->count();

        $list = $query->skip(($page - 1) * $size)->take($size)->get();
        $data = [
            "list" => $list,
            "page" => new Paginate($count, $size)
        ];
        return $this->render("permission.index", $data);
    }

    /**
     * 创建/修改 权限
     *
     * @param Request $req
     * @param Response $res
     * @return string
     */
    public function data(Request $req, Response $res)
    {
        $data = [];
        $id = $req->getParam("id", 0);
        if (!empty($id)) {
            $info = AdminPermission::find($id);
        } else {
            $info = new AdminPermission();
        }
        $data["info"] = $info;
        return $this->render("permission.data", $data);
    }

    /**
     * 保存提交内容
     *
     * @param Request $req
     * @param Response $res
     * @return mixed
     */
    public function save(Request $req, Response $res)
    {
        $id = $req->getParam("id", 0);
        if (is_numeric($id) && $id > 0) {
            return $this->doUpdate($req, $res);
        } else {
            return $this->doCreate($req, $res);
        }
    }

    /**
     * 验证创建权限数据
     *
     * @param Request $req
     * @throws SlimException
     */
    protected function validateCreate(Request $req)
    {
        try {
            Assert::notEmpty($req->getParam("name", ""), "权限名称不能为空");
            Assert::notEmpty($req->getParam("slug", ""), "权限标识不能为空");
        } catch (\Exception $e) {
            throw new SlimException($req, $this->reject($e->getMessage(), $this->redirectToData()));
        }
    }

    /**
     * 验证更新权限数据
     *
     * @param Request $req
     * @throws SlimException
     */
    protected function validateUpdate(Request $req)
    {
        try {
            Assert::notEmpty($req->getParam("name", ""), "权限名称不能为空");
            Assert::notEmpty($req->getParam("slug", ""), "权限标识不能为空");
        } catch (\Exception $e) {
            throw new SlimException($req, $this->reject($e->getMessage(), $this->redirectToData($req->getParam("id", 0))));
        }
    }

    /**
     * 创建数据
     *
     * @param Request $req
     * @param Response $res
     * @return mixed
     * @throws SlimException
     */
    protected function doCreate(Request $req, Response $res)
    {
        $this->validateCreate($req);

        $result = AdminPermission::create([
            "name" => $req->getParam("name", ""),
            "slug" => $req->getParam("slug", "")
        ]);

        if ($result !== false) {
            return $this->resolve("数据保存成功", $this->redirectToList());
        } else {
            return $this->reject("数据保存失败请重试", $this->redirectToData());
        }
    }

    /**
     * 更新数据
     *
     * @param Request $req
     * @param Response $res
     * @return mixed
     */
    protected function doUpdate(Request $req, Response $res)
    {
        $id = $req->getParam("id", 0);

        $this->validateUpdate($req);

        $result = AdminPermission::where("id", $id)->update([
            "name" => $req->getParam("name", ""),
            "slug" => $req->getParam("slug", "")
        ]);

        if ($result !== false) {
            return $this->resolve("数据更新成功", $this->redirectToList());
        } else {
            return $this->reject("数据更新失败请重试", $this->redirectToData($id));
        }
    }

    /**
     * 删除权限信息
     *
     * @param Request $req
     * @param Response $res
     * @return mixed
     */
    public function doDelete(Request $req, Response $res)
    {
        $id = $req->getParam("id", "");
        $id = array_filter(explode(",", $id));

        if (empty($id)) {
            return $this->reject("请选择要删除的项", $this->redirectToList());
        }

        $result = $this->db->table("admin_permission")->whereIn("id", $id)->delete();

        if ($result !== false) {
            return $this->resolve("权限删除成功", $this->redirectToList());
        } else {
            return $this->reject("权限删除失败请重试", $this->redirectToList());
        }
    }

    /**
     * 获取列表地址
     *
     * @return string
     */
    public function redirectToList()
    {
        return admUrl("/permission");
    }

    /**
     * 获取编辑地址
     *
     * @param int $id
     * @return string
     */
    public function redirectToData($id = 0)
    {
        return $id == 0 ? admUrl("/permission/data") : admUrl("/permission/data?id=" . $id);
    }


}