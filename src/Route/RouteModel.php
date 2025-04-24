<?php

namespace Basic\Route;

use Basic\Interface\BasicControllerInterface;
use Closure;

readonly class RouteModel
{
    private function __construct(
        private string $method,
        private string $path,
        private Closure $controller_closure,
    )
    {
    }

    public static function fromArray(array $route): self
    {
        return new self(
            method: $route['method'],
            path: $route['path'],
            controller_closure: $route['controller_closure'],
        );
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getController(): BasicControllerInterface
    {
        return call_user_func($this->controller_closure);
    }
}
