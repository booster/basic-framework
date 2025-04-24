<?php
declare(strict_types=1);
namespace Basic\Route;

use Basic\ResponseTypes\Type;
use Closure;
use Psr\Container\ContainerInterface;

class Router
{
    public function __construct(private array $registered_routes = [])
    {
    }

    public function get(string $path, Closure $closure, Type $content_type): void
    {
        $this->registered_routes['GET'][$path]['closure'] = $closure;
        $this->registered_routes['GET'][$path]['content_type'] = $content_type;
    }

    public function post(string $path, Closure $closure, Type $type): void
    {
        $this->registered_routes['POST'][$path]['closure'] = $closure;
        $this->registered_routes['POST'][$path]['content_type'] = $type;
    }

    public function resolveRoute(string $method, string $path): ?RouteModel
    {
        $route_exists = array_key_exists($path, $this->registered_routes[$method]);

        return $route_exists
            ? RouteModel::fromArray([
                'method' => $method,
                'path' => $path,
                'controller_closure' => $this->registered_routes[$method][$path]['closure'],
                'content_type' => $this->registered_routes[$method][$path]['content_type'],
            ])
            : null;
    }

}
