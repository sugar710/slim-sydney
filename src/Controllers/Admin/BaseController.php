<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\AdminMenu;
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
        $this->db;
        $this->now = date('Y-m-d H:i:s');
        $this->adminUser = $this->session->get("admUser");
        $this->adminShare();
    }

    /**
     * 管理后台公用模板数据
     */
    private function adminShare() {
        $adminMenus = AdminMenu::levelMenu();
        $this->view->share("adminUser", $this->adminUser);
        $this->view->share("adminMenus", $adminMenus);
        $this->view->share("adminPath", $this->req->getUri()->getPath());
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