<?php

namespace App\Controllers\Admin;

use App\Models\Model;
use Slim\Exception\SlimException;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * 数据处理
 *
 * @property \duncan3dc\Laravel\BladeInstance view
 * @property \Slim\Flash\Messages flash
 * @property \Illuminate\Database\Capsule\Manager db
 * @property \SlimSession\Helper session
 * @property \Monolog\Logger logger
 * @property \Illuminate\Database\Schema\Builder schema
 * @property \Slim\Http\Request req
 * @property \Slim\Http\Response res
 * @property \Slim\Router router
 *
 * Trait DataProcessTrait
 * @package App\Controllers\Admin
 */
trait DataProcessTrait
{

    /**
     * 保存数据
     *
     * @param Request $req
     * @param Response $res
     * @return mixed
     */
    public function save(Request $req, Response $res)
    {
        $id = $req->getParam("id", 0);
        if (is_numeric($id) && $id > 0) {
            return $this->doUpdate($req, $res);
        } else {
            return $this->doCreate($req, $res);
        }
    }

    /**
     * 创建数据
     *
     * @param Request $req
     * @param Response $res
     * @return mixed
     */
    public function doCreate(Request $req, Response $res)
    {
        $this->validateCreate($req);
        $data = $this->fieldFilter($req->getParams());

        try {
            $info = $this->model->create($data);
            $this->relation($info, $req);
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
        $data = array_merge($data, ["updated_at" => date("Y-m-d H:i:s")]);

        try {
            $info = $this->model->find($id);
            $this->model->where("id", $id)->update($data);
            $this->relation($info, $req);
        } catch (\Exception $e) {
            $this->logException($req, $e);
            return $this->reject("数据更新失败请重试", $this->backUrl());
        }
        return $this->resolve("数据更新成功", $this->redirectToList());
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
            $list = $this->model->whereIn("id", $id)->get();
            foreach ($list as $item) {
                $this->relation($item, $req);
                $item->delete();
            }
        } catch (\Exception $e) {
            $this->logException($req, $e);
            return $this->reject("数据删除失败请重试", $this->backUrl());
        }

        return $this->resolve("数据删除成功", $this->redirectToList());
    }

    /**
     * 处理模型关联数据
     *
     * @param Model $info
     * @param Request $req
     * @return bool
     */
    protected function relation(Model $info, Request $req)
    {
        return true;
    }

    /**
     * 过滤非表字段数据
     *
     * @param array $fields
     * @return array
     */
    protected function fieldFilter(array $fields = [])
    {
        $tableName = $this->model->getTable();
        $columns = $this->schema->getColumnListing($tableName);
        $fields = array_filter($fields, function ($field) use ($columns) {
            return in_array($field, $columns);
        }, ARRAY_FILTER_USE_KEY);
        return $fields;
    }


}