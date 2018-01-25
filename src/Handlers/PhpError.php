<?php

namespace App\Handlers;

use Psr\Container\ContainerInterface;

/**
 * 错误处理
 *
 * Class PhpError
 * @package App\Handlers
 */
class PhpError extends \Slim\Handlers\PhpError
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $displayErrorDetails = $this->container["settings"]["displayErrorDetails"];
        $outputBuffering = $this->container["settings"]["outputBuffering"];
        parent::__construct($displayErrorDetails, $outputBuffering);
    }

    protected function renderHtmlErrorMessage(\Throwable $error)
    {
        return $this->container["view"]->render("errors.500", [
            "err" => $error
        ]);
    }
}