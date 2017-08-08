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

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->adminUser = $this->session->get("admUser");
        $this->view->share("adminUser", $this->adminUser);
        $this->db;
    }
}