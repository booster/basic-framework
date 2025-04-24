<?php
declare(strict_types=1);
namespace Basic\Route;

use Closure;

class Router
{
    public function __construct(private array $registered_routes = [])
    {
    }

    public function get(string $path, Closure $closure): void
    {
        $this->registered_routes['GET'][$path]['closure'] = $closure;
    }

    public function post(string $path, Closure $closure): void
    {
        $this->registered_routes['POST'][$path]['closure'] = $closure;
    }

    public function resolveRoute(string $method, string $path): ?RouteModel
    {
        $route_exists = array_key_exists($path, $this->registered_routes[$method]);

        return $route_exists
            ? RouteModel::fromArray([
                'method' => $method,
                'path' => $path,
                'controller_closure' => $this->registered_routes[$method][$path]['closure'],
            ])
            : null;
    }

}
