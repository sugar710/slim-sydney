<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\AdminMenu;
use App\Models\User;
use Slim\Container;

/**
 * Admin 基础控制器
 *
 * Class BaseController
 * @package App\Controllers\Admin
 */
class BaseController extends Controller
{
    protected $adminUser;

    protected $viewFolder = 'adm';

    protected $now = '';

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->now = date('Y-m-d H:i:s');
        $this->adminUser = $this->session->get("admUser");
        $this->adminUser = User::find($this->adminUser->id);
        $this->adminShare();
    }

    /**
     * 管理后台公用模板数据
     */
    private function adminShare() {
        //$adminMenus = AdminMenu::levelMenu();
        $adminMenus = $this->getAdminMenus();
        $this->view->share("adminUser", $this->adminUser);
        $this->view->share("adminMenus", $adminMenus);
        $this->view->share("adminPath", $this->req->getUri()->getPath());
    }

    /**
     * 获取管理用户可访问菜单
     *
     * @return array
     */
    private function getAdminMenus() {
        $list = AdminMenu::orderBy("sort", "desc")->with(["router"])->orderBy("id", "asc")->get(["id", "pid", "name", "router_id"]);
        $routers = $this->getUserRouters();
        $list = $list->filter(function($item) use ($routers) {
            if(empty($item->router)) {
                return true;
            }
            return in_array($item->router->id, $routers);
        });
        return levelArr($list->toArray(), 0, 'pid');
    }

    /**
     * 获取当前用户可访问路由
     *
     * @return array
     */
    private function getUserRouters() {
        $userRouter = $this->adminUser->routers()->pluck("router_id")->toArray();
        $roles = $this->adminUser->roles()->pluck("role_id")->toArray();
        $roleRouter = $this->table("admin_role_router")->whereIn("role_id", $roles)->pluck("router_id")->toArray();
        return array_unique(array_merge($userRouter ?: [], $roleRouter ?: []));

    }

    /**
     * 渲染页面
     *
     * @param $view
     * @param array $params
     * @return string
     */
    public function render($view, array $params = [])
    {
        $view = strstr($view, $this->viewFolder) === 0 ? $view : $this->viewFolder . '.' . $view;
        return $this->view->render($view, $params);
    }

}