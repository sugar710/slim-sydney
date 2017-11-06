<?php

namespace App\Controllers\Admin;

use App\Models\AdminLog;
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
        $logs = AdminLog::orderBy("id", "desc")->take(11)->get();
        $data = [
            "logs" => $logs,
        ];
        return $this->view->render("adm.home", $data);
    }

}