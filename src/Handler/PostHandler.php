<?php
declare(strict_types=1);

namespace Basic\Handler;

use Basic\Interface\BasicHandlerInterface;
use Basic\Route\Router;
use Closure;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

readonly class PostHandler implements BasicHandlerInterface
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function resolveRequest(ServerRequestInterface $request): ?ResponseInterface
    {
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();

        $controller = $this->resolveRoute(method: $method, path: $path);

        $params = $request->getParsedBody() ?? [];

        return $controller ? (call_user_func($controller))->getResponse(...$params) : null;
    }

    private function resolveRoute(string $method, string $path): ?Closure
    {
        /** @var Router $route */
        $route = $this->container->get(Router::class);

        return $route->resolveRoute(method: $method, path: $path);
    }
}
