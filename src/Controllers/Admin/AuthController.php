<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\User;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthController extends Controller
{

    /**
     * 登录界面
     *
     * @param Request $req
     * @return string
     */
    public function login(Request $req)
    {
        return $this->view->render("adm.auth.login", [
            "returnUrl" => $req->getParam("returnUrl", "")
        ]);
    }

    /**
     * 验证登录
     *
     * @param Request $req
     * @param Response $res
     * @return Response|string
     */
    public function doLogin(Request $req, Response $res)
    {
        $returnUrl = $req->getParam("returnUrl", "");
        $username = $req->getParam("username");
        $password = $req->getParam("password");
        $info = User::where("username", $username)->first();
        if (empty($info)) {
            return $this->reject("账号或密码错误", $this->backUrl());
        }
        $result = password_verify($password, $info->password);
        if ($result) {
            $this->session->set("admUser", $info);
            return $this->resolve("登录成功", $returnUrl ?: admUrl('/'));
        } else {
            return $this->reject("账号或密码错误", $this->backUrl());
        }
    }


    /**
     * 退出登录
     *
     * @param Request $req
     * @param Response $res
     * @return Response|string
     */
    public function logout(Request $req, Response $res)
    {
        $this->session->clear();
        return $this->resolve("退出成功", admUrl('/login'));
    }

}