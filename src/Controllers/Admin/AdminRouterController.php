<?php

namespace App\Controllers\Admin;

use App\Models\AdminRouter;
use App\Utils\Paginate;
use Slim\Exception\SlimException;
use Slim\Http\Request;
use Webmozart\Assert\Assert;

/**
 * 路由管理
 *
 * Class AdminRouterController
 * @package App\Controllers\Admin
 */
class AdminRouterController extends BaseController implements DataProcessInterface
{
    use DataProcessTrait;

    protected $viewFolder = "adm.authority";

    protected $modelName = AdminRouter::class;

    /**
     * 路由项管理列表
     *
     * @param Request $req
     * @return string
     */
    public function index(Request $req)
    {
        $size = 20;
        $page = $req->getParam("page", 1);
        $page = $page > 0 ? $page : 1;
        $keyword = $req->getParam("keyword", "");
        $query = $this->model->orderBy("sort", "desc");

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->orWhere("name", "like", "%{$keyword}%")
                    ->orWhere("slug", $keyword)
                    ->orWhere("path", "like", "%{$keyword}%");
            });
        }
        $count = $query->count();
        $list = $query->skip(($page - 1) * $size)->take($size)->get();
        $data = [
            "list" => $list,
            "page" => new Paginate($count, $size),
            "req" => $req->getParams()
        ];
        return $this->render("router.index", $data);
    }

    /**
     * 创建/编辑路由
     * @param Request $req
     * @return string
     */
    public function data(Request $req)
    {
        $data = [];
        $id = $req->getParam("id", 0);
        if ($id > 0) {
            $info = $this->model->find($id);
        } else {
            $info = new AdminRouter();
        }
        $data["info"] = $info;
        $data["adminPath"] = "/admin/router";
        return $this->render("router.data", $data);
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
            Assert::notEmpty($req->getParam("name", ""), "路由名称不能为空");
            Assert::notEmpty($req->getParam("path", ""), "路由地址不能为空");
            Assert::notEmpty($req->getParam("slug", ""), "路由标记不能为空");
            Assert::true(in_array($req->getParam("status", "T"), ["T", "F"]), "启用状态不正确");
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
            Assert::notEmpty($req->getParam("name", ""), "路由名称不能为空");
            Assert::notEmpty($req->getParam("path", ""), "路由地址不能为空");
            Assert::notEmpty($req->getParam("slug", ""), "路由标记不能为空");
            Assert::true(in_array($req->getParam("status", "T"), ["T", "F"]), "启用状态不正确");
        } catch (\Exception $e) {
            throw new SlimException($req, $this->reject($e->getMessage(), $this->backUrl()));
        }
    }

    /**
     * 角色列表地址
     *
     * @return string
     */
    protected function redirectToList()
    {
        return $this->router->pathFor('admin.router');
    }
}