<?php

namespace Basic\Route;

use Closure;
use Psr\Container\ContainerInterface;

class Router
{
    public function __construct(private ContainerInterface $container, private array $registered_routes = [])
    {
    }

    public function get(string $path, Closure $closure): void
    {
        $this->registered_routes['GET'][$path] = $closure;
    }

    public function post(string $path, Closure $closure): void
    {
        $this->registered_routes['POST'][$path] = $closure;
    }

    public function resolveRoute(string $method, string $path): ?Closure
    {
        return $this->registered_routes[$method][$path] ?? null;
    }

}
