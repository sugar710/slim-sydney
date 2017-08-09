<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
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

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->adminUser = $this->session->get("admUser");
        $this->view->share("adminUser", $this->adminUser);
        $this->db;
    }

    /**
     * 渲染页面
     *
     * @param $view
     * @param array $params
     * @return string
     */
    public function render($view, array $params = []) {
        $view = $this->viewFolder . '.' . ltrim($view, $this->viewFolder);
        return $this->view->render($view, $params);
    }

    /**
     * 操作成功响应
     *
     * @param $message
     * @param $url
     * @return mixed
     */
    public function resolve($message, $url) {
        return responseResolve($message, $url);
    }

    /**
     * 操作失败响应
     *
     * @param $message
     * @param $url
     * @return mixed
     */
    public function reject($message, $url) {
        return responseReject($message, $url);
    }
}