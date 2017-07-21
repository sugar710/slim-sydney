<?php

namespace App\Controllers;

use App\Models\User;
use Slim\Http\Request;
use Slim\Http\Response;
use Webmozart\Assert\Assert;

class InstallController extends Controller {

    /**
     * 欢迎页面
     *
     * @return string
     */
    public function welcome() {
        return $this->view->render("install.welcome");
    }

    /**
     * 同意协议
     *
     * @param Request $req
     * @return Response
     */
    public function agree(Request $req) {
        $agree = $req->getParam("agreement", "F");
        if($agree != "T") {
            return $this->jsonTip(0, "请先阅读并同意协议");
        }
        $this->session->set("install.agree", "T");
        return $this->jsonTip(1, "OK");
    }

    /**
     * 环境检测
     */
    public function env() {
        $data = [];
        $this->session->set("install.env", true);
        $data["base"] = value(function(){
            $list = [
                "os" => [
                    "name" =>"操作系统",
                    "condition" => "不限制",
                    "current" => PHP_OS,
                    "result" => "T"
                ],
                "php" => [
                    "name" => "PHP版本",
                    "condition" => "5.6",
                    "current" => PHP_VERSION,
                    "result" => "T"
                ],
                "gd" => [
                    "name" => "GD库",
                    "condition" => "2.0",
                    "current" => "未知",
                    "result" => "T"
                ],
            ];

            if(version_compare($list["php"]["condition"], PHP_VERSION) >= 0) {
               $list["php"]["result"] = "F";
               $this->session->set("install.env", false);
            }

            $tmp = function_exists("gd_info") ? gd_info() : array();
            if(empty($tmp["GD Version"])) {
                $list["gd"]["current"] = "未安装";
                $this->session->set("install.env", false);
            } else {
                $list["gd"]["current"] = $tmp["GD Version"];
            }
            return $list;
        });

        return $this->view->render("install.env", $data);
    }

    /**
     * 数据库相关配置
     */
    public function database() {

    }

    /**
     * 初始化数据库
     * @param Request $res
     */
    public function createDatabase(Request $res) {

    }

    /**
     * 配置管理员信息
     */
    public function adminUser() {

    }

    /**
     * 创建管理员
     *
     * @param Request $req
     * @param Response $res
     * @return Response
     */
    public function createAdminUser(Request $req, Response $res) {
        $this->db;
        $username = $req->getParam("username", "");
        $password = $req->getParam("password", "");
        try {
            Assert::notEmpty($username, "账号不能为空");
            Assert::notEmpty($password, "密码不能为空");
        } catch(\Exception $e) {
            return $this->jsonTip(0, $e->getMessage());
        }
        $user = User::create([
            "name" => "admin",
            "avatar" => "/public/avatar-default.png",
            "username" => "admin",
            "password" => password_hash("admin", PASSWORD_BCRYPT),
        ]);
        if(!empty($user)) {
            return $this->jsonTip(1, "管理员创建成功");
        } else {
            return $this->jsonTip(0, "管理员创建失败请重试");
        }
    }

}