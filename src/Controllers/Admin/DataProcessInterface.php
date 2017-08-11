<?php

namespace App\Controllers\Admin;

use Slim\Http\Request;
use Slim\Http\Response;

interface DataProcessInterface
{

    /**
     * 创建数据
     *
     * @param Request $req
     * @param Response $res
     * @return mixed
     */
    public function doCreate(Request $req, Response $res);

    /**
     * 更新数据
     *
     * @param Request $req
     * @param Response $res
     * @return mixed
     */
    public function doUpdate(Request $req, Response $res);

    /**
     * 删除数据
     *
     * @param Request $req
     * @param Response $res
     * @return mixed
     */
    public function doDelete(Request $req, Response $res);

}