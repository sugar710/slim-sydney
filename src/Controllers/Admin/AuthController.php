<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthController extends Controller
{

    /**
     * 登录界面
     *
     * @return string
     */
    public function login()
    {
        return $this->view->render("adm.auth.login");
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
        $info = $this->table("admin_user")->where("username", $username)->first();
        if(empty($info)) {
            return $this->reject("账号或密码错误", $this->backUrl());
        }
        $result = password_verify($password, $info->password);
        if ($result) {
            $this->session->set("admUser", $info);
            return $this->resolve("登录成功", admUrl('/home'));
        } else {
            return $this->reject("账号或密码错误", $this->backUrl());
        }
    }

    /**
     * 退出登录
     *
     * @param Request $req
     * @param Response $res
     * @return Response
     */
    public function logout(Request $req, Response $res) {
        $this->session->delete("admUser");
        return $this->resolve("登出成功", admUrl('/login'));
    }

}