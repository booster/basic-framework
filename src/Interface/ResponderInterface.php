<?php

namespace Basic\Interface;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ResponderInterface
{
    public function respond(ServerRequestInterface $request, array $content): ResponseInterface;
}
