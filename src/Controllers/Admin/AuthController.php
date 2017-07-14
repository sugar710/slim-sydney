<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use Slim\App;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * @property \duncan3dc\Laravel\BladeInstance view
 * @property \Slim\Flash\Messages flash
 * @property \Illuminate\Database\Capsule\Manager db
 * @property \SlimSession\Helper session
 */
class AuthController extends Controller
{

    /**
     * 登录界面
     *
     * @return string
     */
    public function login()
    {
        $data = [];
        return $this->view->render("adm.auth.login", $data);
    }

    /**
     * 验证登录
     *
     * @param Request $req
     * @param Response $res
     * @return Response
     */
    public function doLogin(Request $req, Response $res)
    {
        $username = $req->getParam("username");
        $password = $req->getParam("password");
        $info = $this->db->table("admin_user")->where("username", $username)->first();
        if(empty($info)) {
            flash('auth.error', '账号或密码错误');
            return $res->withRedirect('/admin/login');
        }
        $result = password_verify($password, $info->password);
        if ($result) {
            $this->session->set("admUser", $info);
            return $res->withRedirect('/admin/home');
        } else {
            flash('auth.error', '账号或密码错误');
            return $res->withRedirect('/admin/login');
        }
    }

}