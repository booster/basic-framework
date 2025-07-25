<?php

namespace Basic\Interface;

use Psr\Http\Message\ServerRequestInterface;

interface RequestDTOFactoryInterface
{
    public function map(ServerRequestInterface $server_request, string $requestDTO): RequestDTOInterface;
}