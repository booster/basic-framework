<?php

namespace Basic\Route;

use Basic\Interface\BasicControllerInterface;
use Basic\ResponseTypes\Type;
use Closure;

readonly class RouteModel
{
    private function __construct(
        private string $method,
        private string $path,
        private Closure $controller_closure,
        private Type $content_type,
    )
    {
    }

    public static function fromArray(array $route): self
    {
        return new self(
            method: $route['method'],
            path: $route['path'],
            controller_closure: $route['controller_closure'],
            content_type: $route['content_type']
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

    public function getContentType(): string
    {
        return $this->content_type->value;
    }
}
