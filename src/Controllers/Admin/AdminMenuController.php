<?php

namespace App\Controllers\Admin;

use App\Models\AdminMenu;
use App\Models\AdminRouter;
use App\Utils\Paginate;
use Slim\Exception\SlimException;
use Slim\Http\Request;
use Slim\Http\Response;
use Webmozart\Assert\Assert;

/**
 * 管理后台菜单管理
 *
 * Class AdminMenuController
 * @package App\Controllers\Admin
 */
class AdminMenuController extends BaseController implements DataProcessInterface
{
    use DataProcessTrait;

    protected $viewFolder = "adm.authority";

    protected $modelName = AdminMenu::class;

    /**
     * 菜单列表
     *
     * @param Request $req
     * @param Response $res
     * @return string
     */
    public function index(Request $req, Response $res)
    {
        $query = $this->model->orderBy("sort", "desc")->orderBy("id", "asc");
        $list = $query->get();
        $list = subtree($list->toArray(), 0, 0, 'pid');
        $data = [
            "list" => $list,
            "req" => $req->getParams()
        ];
        return $this->render("menu.index", $data);
    }

    /**
     * 创建/编辑 菜单
     *
     * @param Request $req
     * @return string
     */
    public function data(Request $req)
    {
        $data = [];
        $id = $req->getParam("id", 0);
        if ($id > 0) {
            $info = AdminMenu::find($id);
        } else {
            $info = new AdminMenu();
        }
        $menus = $this->model->orderBy("sort", "desc")->orderBy("id", "asc")->get()->toArray();
        $menus = subtree($menus, 0, 0, 'pid');
        $routers = AdminRouter::orderBy("sort", "desc")->get();
        $data["info"] = $info;
        $data["menus"] = $menus;
        $data["routers"] = $routers;
        $data["adminPath"] = "/admin/menu";
        return $this->render("menu.data", $data);
    }

    /**
     * 验证创建菜单数据
     *
     * @param Request $req
     * @throws SlimException
     */
    protected function validateCreate(Request $req)
    {
        try {
            Assert::notEmpty($req->getParam("name", ""), "菜单名称不能为空");
        } catch (\Exception $e) {
            throw new SlimException($req, $this->reject($e->getMessage(), $this->backUrl()));
        }
    }

    /**
     * 验证更新菜单数据
     *
     * @param Request $req
     * @throws SlimException
     */
    protected function validateUpdate(Request $req)
    {
        try {
            Assert::notEmpty($req->getParam("name", ""), "菜单名称不能为空");
        } catch (\Exception $e) {
            throw new SlimException($req, $this->reject($e->getMessage(), $this->backUrl()));
        }
    }

    /**
     * 菜单列表地址
     *
     * @return string
     */
    protected function redirectToList()
    {
        return $this->router->pathFor('admin.menu');
    }

}