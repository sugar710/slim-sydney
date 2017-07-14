<?php

namespace App;

use Slim\Container as BaseContainer;

/**
 * 存在的目的是为了随时随地获取容器实例及以下对应依赖
 *
 * Class Container
 * @package App
 */
class Container extends BaseContainer {

    public static $container = null;

    public function __construct(array $values = [])
    {
        parent::__construct($values);
        self::setInstance($this);
    }

    /**
     * 获取容器实例
     *
     * @return Container|null|static
     */
    public static function getInstance() {
        if(is_null(self::$container)) {
            return new static;
        }
        return self::$container;
    }

    /**
     * 设置容器实例
     *
     * @param BaseContainer $container
     */
    public static function setInstance(BaseContainer $container) {
        self::$container = $container;
    }

}