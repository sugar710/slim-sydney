<?php

namespace App\Controllers\Admin;

use App\Models\Feedback;
use App\Utils\Paginate;
use Slim\Exception\SlimException;
use Slim\Http\Request;
use Slim\Http\Response;
use Webmozart\Assert\Assert;

/**
 * 反馈
 *
 * Class FeedbackController
 * @package App\Controllers\Admin
 */
class FeedbackController extends BaseController implements DataProcessInterface
{
    use DataProcessTrait;

    protected $viewFolder = "adm";

    protected $modelName = Feedback::class;

    public function index(Request $req, Response $res)
    {
        $size = 20;
        $page = $req->getParam("page", 1);
        $page = $page > 0 ? $page : 1;
        $keyword = $req->getParam("keyword", "");
        $query = $this->model->orderBy("id", "asc");

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->orWhere("name", "like", "%{$keyword}%")->orWhere("content", "like", "%{$keyword}%");
            });
        }
        $count = $query->count();
        $list = $query->skip(($page - 1) * $size)->take($size)->get();
        $data = [
            "list" => $list,
            "page" => new Paginate($count, $size),
            "req" => $req->getParams()
        ];
        return $this->render("feedback.index", $data);
    }

    /**
     * 创建反馈
     *
     * @param Request $req
     * @return string
     */
    public function data(Request $req)
    {
        $data = [];
        $id = $req->getParam("id", 0);
        if ($id > 0) {
            $info = $this->model->find($id);
        } else {
            $info = $this->model;
        }
        $data["info"] = $info;
        return $this->render("feedback.data", $data);
    }

    /**
     * 验证创建反馈数据
     *
     * @param Request $req
     * @throws SlimException
     */
    public function validateCreate(Request $req)
    {
        try {
            Assert::notEmpty($req->getParam("name", ""), "姓名不能为空");
            Assert::notEmpty($req->getParam("email", ""), "邮箱不能为空");
            Assert::true(filter_var($req->getParam("email", ""), FILTER_VALIDATE_EMAIL) !== false, "邮箱格式不正确");
            Assert::notEmpty($req->getParam("content", ""), "反馈内容不能为空");
        } catch (\Exception $e) {
            throw new SlimException($req, $this->reject($e->getMessage(), $this->backUrl()));
        }
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

        return $this->reject("反馈内容就不要删了吧?", $this->backUrl());

    }

    /**
     * 列表地址
     *
     * @return string
     */
    protected function redirectToList()
    {
        return $this->router->pathFor('admin.feedback');
    }
}