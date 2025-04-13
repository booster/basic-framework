<?php

namespace Basic\Handler;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class BasicRequestHandler implements RequestHandlerInterface
{

    public function __construct(private array $middleware_stack = [])
    {
    }

    public function setMiddlewareStack(array $middleware_stack): void
    {
        $this->middleware_stack = $middleware_stack;
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $next = current($this->middleware_stack);

        if (key($this->middleware_stack) === null) {
            return new Response(404, [], 'Not Found');
        }

        next($this->middleware_stack);

        return $next->process($request, $this);
    }
}
