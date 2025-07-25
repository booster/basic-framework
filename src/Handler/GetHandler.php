<?php
declare(strict_types=1);

namespace Basic\Handler;

use Basic\Interface\BasicControllerInterface;
use Basic\Interface\BasicHandlerInterface;
use Basic\Interface\RequestDTOInterface;
use Basic\RequestDTO\RequestDTOFactory;
use Basic\Responder\ResponderFactory;
use Basic\Route\RouteModel;
use Basic\Route\Router;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionMethod;

readonly class GetHandler implements BasicHandlerInterface
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
        $requestDTO = $this->getRequestDTO(server_request: $request, controller: $controller);

        $response = $controller->getResponse($requestDTO);

        return $this->formatResponse(request: $request, content: $response);
    }

    private function formatResponse(ServerRequestInterface $request, array $content): ResponseInterface
    {
        $responder = $this->responderFactory->getResponder(serverRequest: $request);

        return $responder->respond(request: $request, content: $content);
    }

    private function getRequestDTO(ServerRequestInterface $server_request, BasicControllerInterface $controller): ?RequestDTOInterface
    {
        $reflection = new ReflectionMethod($controller, 'getResponse');
        $params = $reflection->getParameters();
        $requestDTO = !empty($params) ? $params[0]->getType()?->getName() : null;

        return  $requestDTO ?? class_exists($requestDTO ?? '') ? $this->requestDTOFactory->map(server_request: $server_request, requestDTO: $requestDTO) : null;
    }

}
