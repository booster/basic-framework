<?php
declare(strict_types=1);
namespace Basic\Dispatcher;

use Basic\Handler\BasicRequestHandler;
use Basic\Interface\DispatchInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

readonly class RouteDispatcher implements DispatchInterface
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function dispatch(ServerRequestInterface $request): ?ResponseInterface
    {
        /** @var BasicRequestHandler $request_handler */
        $request_handler = $this->container->get(BasicRequestHandler::class);

        return $request_handler->resolveRequest(request: $request);
    }
}
