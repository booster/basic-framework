<?php
declare(strict_types=1);

namespace Basic\Provider;
use Basic\Handler\GetHandler;
use Basic\Handler\PostHandler;
use Basic\Interface\BasicHandlerInterface;
use Basic\Interface\BasicProviderInterface;
use Psr\Container\ContainerInterface;

class HandlerProvider implements BasicProviderInterface
{
    public function __construct(private readonly ContainerInterface $container, private array $handlers = [])
    {
    }

    public function register(): void
    {
        $this->handlers = [
            'GET' => GetHandler::class,
            'POST' => PostHandler::class,
        ];
    }

    public function getRequestHandler(string $method): ?BasicHandlerInterface
    {
        return $this->handlers[$method] ? $this->container->get($this->handlers[$method]) : null;
    }
}
