<?php

namespace App\Utils;

/**
 * 分页码生成
 *
 * Class Paginate
 * @package App\Utils
 */
class Paginate
{
    protected $req;
    //总条数
    protected $total = 0;
    //每页显示数
    protected $size = 20;
    //默认主题
    protected $theme = 'default';
    //总页码
    protected $pages = 0;
    //分页栏显示条码数
    protected $rollPage = 15;
    //当前页
    protected $nowPage = 1;
    //分页参数
    protected $params = [];
    //分页地址
    protected $url = '';

    public function __construct($total = 0, $size = 20, $params = [], $theme = 'default')
    {
        $this->req = make("request");
        $this->url = $this->req->getUri()->getPath();
        $this->total = $total;
        $this->size = $size;

        if (empty($params)) {
            parse_str($this->req->getUri()->getQuery(), $this->params);
        } else {
            $this->params = $params;
        }

        $this->theme = $theme;
        $this->pages = ceil($this->total / $this->size);

        $page = $this->req->getParam("page", 1);
        $this->nowPage = $page > 0 ? $page : 1;
    }

    /**
     * 设置分页参数
     *
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    public function addParam($key, $val)
    {
        $this->params[$key] = $val;
    }

    public function toPage($num)
    {
        $this->params["page"] = $num;
        return $this->url . '?' . http_build_query($this->params);
    }

    /**
     * @return string
     */
    public function render()
    {
        $center_page = $this->rollPage / 2;
        $roll = [];
        for ($i = 1; $i <= $this->rollPage; $i++) {
            // 特殊情况 当前页码在中间码左侧
            if ($this->nowPage - $center_page <= 0) {
                $page = $i;
            } // 特殊情况 当前页码在中间码右侧
            else if ($this->nowPage + $center_page - 1 >= $this->pages) {
                $page = $this->pages - $this->rollPage + $i;
            } //正常情况 当前页码在正中间
            else {
                $page = $this->nowPage - ceil($center_page) + $i;
            }
            if ($page > 0 && $page <= $this->pages) {
                $roll[] = $page;
            }

        }
        $data = [
            "first" => 1,
            "page" => $this,
            "prev" => $this->nowPage - 1 > 0 ? $this->nowPage - 1 : false,
            "next" => $this->nowPage + 1 <= $this->pages ? $this->nowPage + 1 : false,
            "now" => $this->nowPage,
            "last" => $this->pages,
            "roll" => $roll,
        ];
        return make("view")->render("adm.paginate." . $this->theme, $data);
    }

    public function __toString()
    {
        return $this->render();
    }

}