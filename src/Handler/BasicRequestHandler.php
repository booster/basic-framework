<?php
declare(strict_types=1);

namespace Basic\Handler;

use Basic\Interface\BasicHandlerInterface;
use Basic\Provider\HandlerProvider;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

readonly class BasicRequestHandler
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function resolveRequest(ServerRequestInterface $request): ?ResponseInterface
    {
        /** @var HandlerProvider $request_provider */
        $request_provider = $this->container->get(HandlerProvider::class);

        /** @var BasicHandlerInterface $handler */
        $handler = $request_provider->getRequestHandler($request->getMethod());

        return $handler?->resolveRequest(request: $request) ?? null;
    }
}
