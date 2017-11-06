<?php

namespace App\Controllers\Admin;

use App\Models\AdminLog;
use App\Utils\Paginate;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * 日志查询
 *
 * Class AdminLogController
 * @package App\Controllers\Admin
 */
class AdminLogController extends BaseController
{

    protected $model = AdminLog::class;

    /**
     * 日志列表
     *
     * @param Request $req
     * @param Response $res
     * @return string
     */
    public function index(Request $req, Response $res)
    {
        $size = 50;
        $page = $req->getParam("page", 1);
        $page = $page > 0 ? $page : 1;
        $keyword = $req->getParam("keyword", "");
        $query = call_user_func_array([$this->model, 'orderBy'], ['id', 'desc']);

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->orWhere("path", "like", "%{$keyword}%");//->orWhere("input", "like", "%{$keyword}%");
            });
        }
        $count = $query->count();
        $list = $query->skip(($page - 1) * $size)->take($size)->get();
        $data = [
            "list" => $list,
            "page" => new Paginate($count, $size),
            "req" => $req->getParams()
        ];
        return $this->view->render('adm.log', $data);
    }

    /**
     * 删除数据
     *
     * @param Request $req
     * @param Response $res
     * @return mixed
     */
    public function doDelete(Request $req, Response $res)
    {
        $id = $req->getParam("id", "");
        $id = array_filter(explode(",", $id));

        if (empty($id)) {
            return $this->reject("请选择要删除的项", $this->backUrl());
        }

        try {
            //$info = call_user_func([$this->model, 'where'], "id", $id)->first();
            call_user_func([$this->model, 'whereIn'], "id", $id)->delete();
            //$this->relation($info, $req);
        } catch (\Exception $e) {
            //$this->logException($req, $e);
            return $this->reject("数据删除失败请重试", $this->backUrl());
        }

        return $this->resolve("数据删除成功", $this->redirectToList());
    }

    /**
     * 菜单列表地址
     *
     * @return string
     */
    protected function redirectToList() {
        return $this->router->pathFor('admin.log');
    }

}