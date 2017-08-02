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
     * 验证协议
     *
     * @param Request $req
     * @return Response
     */
    public function agreeVerify(Request $req) {
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
     *
     * return Response
     */
    public function database() {
        $data = [];
        return $this->view->render("install.database", $data);
    }

    /**
     * 验证数据库配置
     *
     * @param Request $req
     * @param Response $res
     * @return Response
     */
    public function databaseVerify(Request $req, Response $res) {
        $dbHost = $req->getParam("dbhost", "");
        $dbName = $req->getParam("dbname", "");
        $dbUser = $req->getParam("dbuser", "");
        $dbPassword = $req->getParam("dbpassword", "");
        try {
            Assert::notEmpty($dbHost, "数据库地址不能为空");
            Assert::notEmpty($dbName, "数据库名不能为空");
            Assert::notEmpty($dbUser, "数据库用户不能为空");
            Assert::notEmpty($dbPassword, "数据库密码不能为空");
            new \PDO("mysql:dbname={$dbName};host={$dbHost}", $dbUser, $dbPassword);
        } catch(\Exception $e) {
            return $this->jsonTip(0, $e->getMessage());
        }
        $this->session->set("install.database", [
            "host" => $dbHost,
            "name" => $dbName,
            "user" => $dbUser,
            "password" => $dbPassword
        ]);
        return $this->jsonTip(1, "配置成功");
    }

    /**
     * 配置管理员信息
     *
     * @return string
     */
    public function accountConf() {
        return $this->view->render("install.account");
    }

    /**
     * 验证管理员信息
     *
     * @param Request $req
     * @return Response
     */
    public function accountVerify(Request $req) {
        $adminName = $req->getParam("admin_name", "");
        $adminAccount = $req->getParam("admin_username", "");
        $adminPassword = $req->getParam("admin_password", "");
        $adminEmail = $req->getParam("admin_email", "");
        try {
            Assert::notEmpty($adminAccount, "管理员账号不能为空");
            Assert::notEmpty($adminPassword, "管理员密码不能为空");
            Assert::notEmpty($adminName, "管理员名称不能为空");
            Assert::notEmpty($adminEmail, "邮箱地址不能为空");
        } catch(\Exception $e) {
            return $this->jsonTip(0, $e->getMessage());
        }
        $this->session->set("install.admin", [
            "username" => $adminAccount,
            "password" => $adminPassword,
            "name" => $adminName,
            "email" => $adminEmail,
        ]);
        return $this->jsonTip(1, "配置成功");
    }

    /**
     * 执行安装
     */
    public function doInstall() {
        echo $this->view->render("install.installing");
        $this->flush();
        $this->createTables();
        $this->createAccount();
        touch('./install.lock');
    }

    /**
     * 创建表结构
     */
    private function createTables() {
        $this->showMsg("开始创建表结构");

        $pdo = $this->getPdo();
        $sqls = $this->getSqlList();
        foreach($sqls as $sql ) {
            $result = true;
            try {
                $pdo->exec($sql);
            } catch(\Exception $e) {
                $errMsg = $e->getMessage();
                $result = false;
            }
            if(strpos($sql, "CREATE TABLE") === 0) {
                $name = preg_replace("/CREATE TABLE (IF NOT EXISTS)? `(\w+)` .*/s", "\\2", $sql);
                $this->showMsg("创建数据表 " . $name, $result ? "ok" : "error");
                if(isset($errMsg)) {
                    $this->showMsg("错误消息 " . $errMsg);
                }
            }
        }
        $this->showMsg("表结构创建结束");
    }

    /**
     * 创建管理员
     *
     * @return bool
     */
    private function createAccount() {
        $now = time();
        $pdo = $this->getPdo();
        $config = $this->session->get("install.admin");
        $sth = $pdo->prepare("INSERT INTO admin_user (name,avatar,username,password,created_at,updated_at) VALUES(:name,:avatar,:username,:password,:created_at,:updated_at)");
        $sth->bindValue(":name", $config["name"]);
        $sth->bindValue(":avatar", "/public/avatar-default.png");
        $sth->bindValue(":username", $config["username"]);
        $sth->bindValue(":password", password_hash($config["password"], PASSWORD_BCRYPT));
        $sth->bindValue(":created_at", $now);
        $sth->bindValue(":updated_at", $now);
        $result = $sth->execute();
        $this->showMsg("创建管理员账号", $result ? "ok" : "error");
        return $result;
    }

    /**
     * 显示创建消息
     *
     * @param $msg
     * @param string $status
     */
    private function showMsg($msg, $status = "") {
        echo "<script type=\"text/javascript\">showMsg(\"{$msg}\", \"{$status}\")</script>";
        $this->flush();
    }

    private function flush() {
        echo str_repeat(" ", 4096);
        ob_flush();
        flush();
    }

    /**
     * 获取PDO对象
     *
     * @return \PDO
     */
    private function getPdo() {
        $config = $this->session->get("install.database");
        $dbHost = $config["host"];
        $dbName = $config["name"];
        $dbUser = $config["user"];
        $dbPassword = $config["password"];
        return new \PDO("mysql:dbname={$dbName};host={$dbHost}", $dbUser, $dbPassword, [
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
        ]);
    }

    /**
     * 获取SQL列表
     *
     * @param string $sqlFile sql文件地址
     * @return array
     */
    private function getSqlList($sqlFile = "../doc/slimLte.sql") {
        $sqlContent = file_get_contents($sqlFile);
        $sqlContent = str_replace("\r", "\n", $sqlContent);
        $sqls = explode("\n", $sqlContent);
        $sqls = array_filter($sqls, function($item) {
            if(empty($item)) {
                return false;
            }
            return !preg_match("#^--|LOCK|UNLOCK|/\*#", trim($item));
        });
        $sqls = explode(";\n", implode("\n", $sqls));
        return $sqls;
    }

}