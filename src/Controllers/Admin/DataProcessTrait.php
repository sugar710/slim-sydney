<?php

namespace App\Controllers\Admin;

use Slim\Exception\SlimException;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * 数据处理
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
     * @throws SlimException
     */
    public function doCreate(Request $req, Response $res)
    {
        $this->validateCreate($req);

        $data = $this->filterField($req->getParams());
        $now = date("Y-m-d H:i:s");
        $data = array_merge($data, ["created_at" => $now, "updated_at" => $now]);
        try {
            $result = $this->table($this->dataTable)->insert($data);
        } catch (\Exception $e) {
            $this->logException($req, $e);
            return $this->reject("数据保存失败请重试", $this->backUrl());
        }


        if ($result !== false) {
            return $this->resolve("数据保存成功", $this->redirectToList());
        } else {
            return $this->reject("数据保存失败请重试", $this->backUrl());
        }
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

        $data = $this->filterField($req->getParams());
        $data = array_merge($data, ["updated_at" => date("Y-m-d H:i:s")]);

        try {
            $result = $this->table($this->dataTable)->where("id", $id)->update($data);
        } catch (\Exception $e) {
            $this->logException($req, $e);
            return $this->reject("数据更新失败请重试", $this->backUrl());
        }

        if ($result !== false) {
            return $this->resolve("数据更新成功", $this->redirectToList());
        } else {
            return $this->reject("数据更新失败请重试", $this->backUrl());
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

        try {
            $result = $this->table($this->dataTable)->whereIn("id", $id)->delete();
        } catch(\Exception $e) {
            $this->logException($req, $e);
            return $this->reject("数据删除失败请重试", $this->backUrl());
        }

        if ($result !== false) {
            return $this->resolve("数据删除成功", $this->redirectToList());
        } else {
            return $this->reject("数据删除失败请重试", $this->backUrl());
        }
    }

    /**
     * 过滤非表字段数据
     *
     * @param array $fields
     * @return array
     */
    protected function filterField(array $fields = [])
    {
        $columns = $this->schema->getColumnListing($this->dataTable);
        $fields = array_filter($fields, function ($field) use ($columns) {
            return in_array($field, $columns);
        }, ARRAY_FILTER_USE_KEY);
        return $fields;
    }

    /**
     * 记录错误信息
     *
     * @param Request $req
     * @param \Exception $e
     */
    public function logException(Request $req, \Exception $e)
    {
        $this->logger->info($req->getMethod() . " " . $req->getUri()->getPath() . "\n" . $e->getMessage() . "\n" . $e->getTraceAsString());
    }

}