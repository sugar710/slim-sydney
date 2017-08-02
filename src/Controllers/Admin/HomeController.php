<?php

namespace App\Controllers\Admin;

use Slim\Http\Request;
use Slim\Http\Response;

class HomeController extends BaseController
{

    /**
     * 管理后台首页
     *
     * @param Request $req
     * @param Response $res
     * @return string
     */
    public function home(Request $req, Response $res)
    {
        return $this->view->render("adm.home");
    }

}