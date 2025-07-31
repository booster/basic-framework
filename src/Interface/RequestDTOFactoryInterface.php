<?php

namespace Basic\Interface;

use Psr\Http\Message\ServerRequestInterface;

interface RequestDTOFactoryInterface
{
    //public function map(ServerRequestInterface $server_request, string $requestDTO): RequestDTOInterface;
    public function map(ServerRequestInterface $server_request, BasicControllerInterface $controller): RequestDTOInterface;
}