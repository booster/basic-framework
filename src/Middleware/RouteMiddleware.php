<?php

namespace Basic\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Basic\Dispatcher\RouteDispatcher;

class RouteMiddleware implements MiddlewareInterface
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var RouteDispatcher $route_dispatcher */
        $route_dispatcher = $this->container->get(RouteDispatcher::class);

        return $route_dispatcher->dispatch($request) ?? $handler->handle($request);
    }
}
