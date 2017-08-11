<?php

namespace App\Controllers\Admin;

use App\Models\AdminPermission;
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
class AdminPermissionController extends BaseController implements DataProcessInterface
{
    use DataProcessTrait;

    protected $viewFolder = 'adm.authority';

    protected $dataTable = "admin_permission";

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
        $keyword = $req->getParam("keyword", "");
        $query = $this->table($this->dataTable);
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->orWhere("name", "like", "%{$keyword}%")->orWhere("slug", $keyword);
            });
        }
        $count = $query->count();

        $list = $query->skip(($page - 1) * $size)->take($size)->get();
        $data = [
            "list" => $list,
            "page" => new Paginate($count, $size),
            "req" => $req->getParams(),
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
        $data["info"] = (int)$id > 0 ? AdminPermission::find($id) : new AdminPermission;
        //$data["info"] = $this->table($this->dataTable)->find($id);
        return $this->render("permission.data", $data);
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
            throw new SlimException($req, $this->reject($e->getMessage(), $this->backUrl()));
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
            throw new SlimException($req, $this->reject($e->getMessage(), $this->backUrl()));
        }
    }

    /**
     * 获取列表地址
     *
     * @return string
     */
    public function redirectToList()
    {
        return $this->router->pathFor("admin.permission");
    }


}