<?php
declare(strict_types=1);

namespace Basic\Handler;

use Basic\Interface\BasicHandlerInterface;
use Basic\Route\RouteModel;
use Basic\Route\Router;
use Closure;
use Nyholm\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

readonly class GetHandler implements BasicHandlerInterface
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function resolveRequest(ServerRequestInterface $request): ?ResponseInterface
    {
        /** @var Router $router */
        $router = $this->container->get(Router::class);
        $route_model = $router->resolveRoute(method: $request->getMethod(), path: $request->getUri()->getPath());

        return $route_model ? $this->createResponse(request: $request, router_model: $route_model) : null;
    }

    private function createResponse(ServerRequestInterface $request, RouteModel $router_model): ResponseInterface
    {
        $controller = $router_model->getController();
        $response = $controller->getResponse(...$request->getQueryParams());

        $response = implode(', ', $response); // parse response from controller to template engine of your choice, and remove this line

        return new Response(200, ['Content-Type' => $router_model->getContentType()], $response);
    }
}
