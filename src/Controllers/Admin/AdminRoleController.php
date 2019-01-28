<?php

namespace App\Controllers\Admin;


use App\Models\AdminRole;
use App\Models\AdminRouter;
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

    protected $modelName = AdminRole::class;

    public function index(Request $req, Response $res)
    {
        $size = 20;
        $page = $req->getParam("page", 1);
        $page = $page > 0 ? $page : 1;
        $keyword = $req->getParam("keyword", "");
        $query = $this->model->orderBy("id", "asc");

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->orWhere("name", "like", "%{$keyword}%")->orWhere("slug", $keyword);
            });
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
            $info = $this->model->find($id);
            $info->routers = $info->routers()->pluck("router_id")->toArray();
        } else {
            $info = new AdminRole();
            $info->routers = [];
        }
        $routers = AdminRouter::orderBy("sort", "desc")->get();
        $data["routers"] = $routers;
        $data["info"] = $info;
        $data["adminPath"] = "/admin/role";
        return $this->render("role.data", $data);
    }

    /**
     * 验证创建角色数据
     *
     * @param Request $req
     * @throws SlimException
     */
    protected function validateCreate(Request $req)
    {
        try {
            Assert::notEmpty($req->getParam("name", ""), "角色名称不能为空");
            Assert::notEmpty($req->getParam("slug", ""), "角色标识不能为空");
        } catch (\Exception $e) {
            throw new SlimException($req, $this->reject($e->getMessage(), $this->backUrl()));
        }
    }

    /**
     * 验证更新角色数据
     *
     * @param Request $req
     * @throws SlimException
     */
    protected function validateUpdate(Request $req)
    {
        try {
            Assert::notEmpty($req->getParam("name", ""), "角色名称不能为空");
            Assert::notEmpty($req->getParam("slug", ""), "角色标识不能为空");
        } catch (\Exception $e) {
            throw new SlimException($req, $this->reject($e->getMessage(), $this->backUrl()));
        }
    }

    protected function validateDelete(array $id = []) {
        if (in_array(1, $id)) {
            return "内置角色禁止删除";
        }
        return true;
    }

    /**
     * 处理角色路由关联
     *
     * @param AdminRole $info
     * @param Request $req
     * @return bool
     */
    protected function relation(AdminRole $info, Request $req)
    {
        $routers = $req->getParam("routers", []) ?: [];
        $info->routers()->sync($routers);
        return true;
    }

    /**
     * 角色列表地址
     *
     * @return string
     */
    protected function redirectToList()
    {
        return $this->router->pathFor('admin.role');
    }

}
