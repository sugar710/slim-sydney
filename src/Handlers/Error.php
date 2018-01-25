<?php

namespace App\Handlers;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * 异常处理
 *
 * Class Error
 * @package App\Handlers
 */
class Error extends \Slim\Handlers\Error
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container['settings']['displayErrorDetails'],
            $container['settings']['outputBuffering']);
        $this->container = $container;
    }

    public function renderHtmlErrorMessage(\Exception $exception)
    {
        try {
            $content = $this->container->get("view")->render("errors.500", [
                "err" => $exception
            ]);
        } catch (NotFoundExceptionInterface $e) {
            $content = $e->getMessage();
        } catch (ContainerExceptionInterface $e) {
            $content = $e->getMessage();
        }
        return $content;
    }

}