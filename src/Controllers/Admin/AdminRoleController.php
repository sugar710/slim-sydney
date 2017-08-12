<?php

namespace App\Controllers\Admin;


use App\Models\AdminRole;
use App\Utils\Paginate;
use Slim\Exception\SlimException;
use Slim\Http\Request;
use Slim\Http\Response;
use Webmozart\Assert\Assert;

/**
 * 角色管理
 * 
 * Class AdminRoleController
 * @package App\Controllers\Admin
 */
class AdminRoleController extends BaseController implements DataProcessInterface
{
    use DataProcessTrait;

    protected $viewFolder = "adm.authority";

    protected $dataTable = "admin_role";

    public function index(Request $req, Response $res)
    {
        $size = 20;
        $page = $req->getParam("page", 1);
        $page = $page > 0 ? $page : 1;
        $keyword = $req->getParam("keyword", "");
        $query = $this->table($this->dataTable);
        if ($keyword) {
            $query->orWhere("name", "like", "%{$keyword}%")->orWhere("slug", $keyword);
        }
        $count = $query->count();
        $list = $query->skip(($page - 1) * $size)->take($size)->get();
        $data = [
            "list" => $list,
            "page" => new Paginate($count, $size),
            "req" => $req->getParams()
        ];
        return $this->render("role.index", $data);
    }

    /**
     * 创建/编辑角色
     * @param Request $req
     * @return string
     */
    public function data(Request $req)
    {
        $data = [];
        $id = $req->getParam("id", 0);
        if ($id > 0) {
            $info = AdminRole::find($id);
        } else {
            $info = new AdminRole();
        }
        $data["info"] = $info;
        return $this->render("role.data", $data);
    }

    /**
     * 验证创建角色数据
     *
     * @param Request $req
     * @throws SlimException
     */
    protected function validateCreate(Request $req) {
        try {
            Assert::notEmpty($req->getParam("name", ""), "角色名称不能为空");
            Assert::notEmpty($req->getParam("slug", ""), "角色标识不能为空");
        } catch(\Exception $e) {
            throw new SlimException($req, $this->reject($e->getMessage(), $this->backUrl()));
        }
    }

    /**
     * 验证更新角色数据
     *
     * @param Request $req
     * @throws SlimException
     */
    protected function validateUpdate(Request $req) {
        try {
            Assert::notEmpty($req->getParam("name", ""), "角色名称不能为空");
            Assert::notEmpty($req->getParam("slug", ""), "角色标识不能为空");
        } catch(\Exception $e) {
            throw new SlimException($req, $this->reject($e->getMessage(), $this->backUrl()));
        }
    }

}