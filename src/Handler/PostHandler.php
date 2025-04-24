<?php
declare(strict_types=1);

namespace Basic\Handler;

use Basic\Interface\BasicHandlerInterface;
use Basic\Route\RouteModel;
use Basic\Route\Router;
use Nyholm\Psr7\Response;
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
        /** @var Router $router */
        $router = $this->container->get(Router::class);
        $route_model = $router->resolveRoute($request->getMethod(), $request->getUri()->getPath());

        return $route_model ? $this->createResponse(request: $request, route_model: $route_model) : null;
    }

    private function createResponse(ServerRequestInterface $request, RouteModel $route_model): ResponseInterface
    {
        $controller = $route_model->getController();
        $response = $controller->getResponse(...$request->getParsedBody() ?? []);

        $response = implode(', ', $response); // parse response from controller to template engine of your choice, and remove this line

        return new Response(200, ['Content-Type' => $route_model->getContentType()], $response);
    }
}
