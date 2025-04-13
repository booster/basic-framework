<?php

namespace Basic\Dispatcher;

use Basic\Interface\BasicControllerInterface;
use Basic\Route\Router;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

readonly class RouteDispatcher
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function dispatch(ServerRequestInterface $request): ?ResponseInterface
    {
        return $this->resolveRoute(request: $request);
    }

    private function resolveRoute(ServerRequestInterface $request): ?ResponseInterface
    {
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();

        /** @var Router $router */
        $router = $this->container->get(Router::class);
        $closure = $router->resolveRoute(method: $method, path: $path);

        return $closure ? $this->resolveResponse(call_user_func($closure), $request) : null;
    }

    /**
     * This will resolve the response from the registered controller for the requested path
     * This method will also try to pass arguments via array destruct, hence named arguments.
     *
     * @param BasicControllerInterface $controller
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function resolveResponse(BasicControllerInterface $controller, ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getQueryParams();

        return $controller->getResponse(...$params);
    }
}
