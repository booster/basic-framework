<?php

namespace Basic\Dispatcher;

use Basic\Interface\BasicHandlerInterface;
use Psr\Container\ContainerInterface;

class RequestProviderDispatcher
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    public function getRequestHandler(string $method): ?BasicHandlerInterface
    {
        return $this->container->get($method) ?? null;
    }
}
