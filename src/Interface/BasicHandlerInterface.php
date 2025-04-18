<?php

namespace Basic\Interface;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface BasicHandlerInterface
{
    public function resolveRequest(ServerRequestInterface $request): ?ResponseInterface;
}

