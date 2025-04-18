<?php

namespace Basic\Interface;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface DispatchInterface
{
    public function dispatch(ServerRequestInterface $request): ?ResponseInterface;
}
