<?php

namespace Basic\Interface;

use Basic\Route\RouteModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ResponderInterface
{
    public function respond(ServerRequestInterface $request, array $content, string $template): ResponseInterface;
}
