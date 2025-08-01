<?php
declare(strict_types=1);

namespace Basic\Handler;

use Basic\Interface\BasicHandlerInterface;
use Basic\RequestDTO\RequestDTOFactory;
use Basic\Responder\ResponderFactory;
use Basic\Route\RouteModel;
use Basic\Route\Router;
use Nyholm\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

readonly class PostHandler implements BasicHandlerInterface
{
    public function __construct(
        private ContainerInterface $container,
        private ResponderFactory $responderFactory,
        private RequestDTOFactory $requestDTOFactory)
    {
    }

    public function resolveRequest(ServerRequestInterface $request): ?ResponseInterface
    {
        /** @var Router $router */
        $router = $this->container->get(Router::class);
        $route_model = $router->resolveRoute(method: $request->getMethod(), path: $request->getUri()->getPath());

        return $route_model ? $this->createResponse(request: $request, route_model: $route_model) : null;
    }

    private function createResponse(ServerRequestInterface $request, RouteModel $route_model): ResponseInterface
    {
        $controller = $route_model->getController();
        $requestDTO = $this->requestDTOFactory->map(server_request: $request, controller: $controller);
        $response = $controller->getResponse(requestDTO: $requestDTO);

        return $this->formatResponse(request: $request, content: $response);
    }

    private function formatResponse(ServerRequestInterface $request, array $content): ResponseInterface
    {
        $responder = $this->responderFactory->getResponder(serverRequest: $request);

        return $responder->respond(request: $request, content: $content);
    }
}
