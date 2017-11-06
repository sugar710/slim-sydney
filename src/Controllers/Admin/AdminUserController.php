<?php

namespace App\Controllers\Admin;

use App\Models\AdminRole;
use App\Models\AdminRouter;
use App\Models\Model;
use App\Models\User;
use App\Utils\Paginate;
use Slim\Exception\SlimException;
use Slim\Http\Request;
use Slim\Http\Response;
use Webmozart\Assert\Assert;

/**
 * 用户管理
 *
 * Class AdminUserController
 * @package App\Controllers\Admin
 */
class AdminUserController extends BaseController implements DataProcessInterface
{
    use DataProcessTrait;

    protected $viewFolder = "adm.authority";

    protected $dataTable = "admin_user";

    protected $model = User::class;

    /**
     * 用户管理列表
     *
     * @param Request $req
     * @return string
     */
    public function index(Request $req)
    {
        $size = 20;
        $page = $req->getParam("page", 1);
        $page = $page > 0 ? $page : 1;
        $keyword = $req->getParam("keyword", "");
        $query = call_user_func_array([$this->model, 'orderBy'], ['id', 'asc']);
        $query->with(['roles']);
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->orWhere("name", "like", "%{$keyword}%")
                    ->orWhere("username", "like", "%{$keyword}%")
                    ->orWhere("email", "like", "%{$keyword}%");
            });
        }
        $count = $query->count();
        $list = $query->skip(($page - 1) * $size)->take($size)->get();
        $data = [
            "list" => $list,
            "page" => new Paginate($count, $size),
            "req" => $req->getParams()
        ];
        return $this->render("user.index", $data);
    }

    /**
     * 创建/编辑用户
     *
     * @param Request $req
     * @return string
     */
    public function data(Request $req)
    {
        $data = [];
        $id = $req->getParam("id", 0);
        if ($id > 0) {
            $info = call_user_func([$this->model, 'find'], $id);
            $info["roles"] = $info->roles()->pluck("role_id")->toArray();
            $info["routers"] = $info->routers()->pluck("router_id")->toArray();
        } else {
            $info = new $this->model();
            $info["roles"] = [];
            $info["routers"] = [];
        }
        $data["info"] = $info;
        $data["roles"] = AdminRole::orderBy("id", "asc")->get(["id", "name"]);
        $data["routers"] = AdminRouter::orderBy("sort", "desc")->get(["id", "name"]);
        $data["adminPath"] = "/admin/user";
        return $this->render("user.data", $data);
    }

    /**
     * 验证创建用户数据
     *
     * @param Request $req
     * @throws SlimException
     */
    public function validateCreate(Request $req)
    {
        $data = $req->getParams();
        try {
            Assert::notEmpty($data["username"], "账号不能为空");
            Assert::notEmpty($data["password"], "密码不能为空");
            Assert::notEmpty($data["email"], "邮箱地址不能为空");
            Assert::true(in_array($data["is_lock"] ?: "F", ["T", "F"]), "锁定状态不正确");
        } catch (\Exception $e) {
            throw new SlimException($req, $this->reject($e->getMessage(), $this->backUrl()));
        }
    }

    /**
     * 验证更新用户数据
     *
     * @param Request $req
     * @throws SlimException
     */
    public function validateUpdate(Request $req)
    {
        $data = $req->getParams();
        try {
            Assert::notEmpty($data["username"], "账号不能为空");
            Assert::notEmpty($data["email"], "邮箱地址不能为空");
            Assert::true(in_array($data["is_lock"] ?: "F", ["T", "F"]), "锁定状态不正确");
        } catch (\Exception $e) {
            throw new SlimException($req, $this->reject($e->getMessage(), $this->backUrl()));
        }
    }

    /**
     * 创建用户数据
     * @param Request $req
     * @param Response $res
     * @return mixed
     */
    public function doCreate(Request $req, Response $res)
    {
        $this->validateCreate($req);

        $data = $this->fieldFilter($req->getParams());
        $data = array_merge($data, ["created_at" => $this->now, "updated_at" => $this->now]);
        if ($data["password"]) {
            $data["password"] = password_hash($data["password"], PASSWORD_BCRYPT);
        }
        try {
            $user = call_user_func([$this->model, 'create'], $data);
            $this->relation($user, $req);
        } catch (\Exception $e) {
            $this->logException($req, $e);
            return $this->reject("数据保存失败请重试", $this->backUrl());
        }

        return $this->resolve("数据保存成功", $this->redirectToList());
    }

    /**
     * 更新数据
     *
     * @param Request $req
     * @param Response $res
     * @return mixed
     */
    public function doUpdate(Request $req, Response $res)
    {
        $id = $req->getParam("id", 0);
        $this->validateUpdate($req);

        $data = $this->fieldFilter($req->getParams());
        $data = array_merge($data, ["updated_at" => $this->now]);
        if ($data["password"]) {
            $data["password"] = password_hash($data["password"], PASSWORD_BCRYPT);
        } else {
            unset($data["password"]);
        }

        try {
            $user = call_user_func([$this->model, 'find'], $id);
            call_user_func_array([$this->model, 'where'], ["id", $id])->update($data);
            $this->relation($user, $req);
        } catch (\Exception $e) {
            $this->logException($req, $e);
            return $this->reject("数据更新失败请重试", $this->backUrl());
        }

        return $this->resolve("数据更新成功", $this->redirectToList());
    }

    protected function relation(Model $info, Request $req)
    {
        $roles = $req->getParam("roles", []) ?: [];
        $routers = $req->getParam("routers", []) ?: [];
        $info->roles()->sync($roles);
        $info->routers()->sync($routers);
    }

    /**
     * 切换锁定状态
     *
     * @param Request $req
     * @param Response $res
     * @return mixed
     */
    public function doLock(Request $req, Response $res)
    {
        $id = $req->getParam("id", 0);
        $user = User::find($id);
        if (empty($user)) {
            return $this->reject("用户不存在", $this->backUrl());
        }
        if ($user->id == 1 && $user->is_lock == 'F') {
            return $this->reject("默认管理员禁止锁定", $this->backUrl());
        }
        $user->is_lock = $user->is_lock == "T" ? "F" : "T";
        $result = $user->save();
        if ($result) {
            return $this->resolve($user->is_lock == "T" ? "用户锁定成功" : "用户解锁成功", $this->redirectToList());
        } else {
            return $this->reject("操作失败", $this->backUrl());
        }
    }

    /**
     * 用户列表地址
     *
     * @return string
     */
    protected function redirectToList()
    {
        return $this->router->pathFor('admin.user');
    }
}