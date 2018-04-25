<?php

namespace App\Handlers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * 404 处理
 *
 * Class NotFound
 * @package App\Handlers
 */
class NotFound extends \Slim\Handlers\NotFound
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    protected function renderHtmlNotFoundOutput(ServerRequestInterface $request)
    {
        return $this->container["view"]->render("errors.404");
    }
}