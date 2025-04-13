<?php

namespace Basic\Interface;

use Psr\Http\Message\ResponseInterface;

interface BasicControllerInterface
{
    public function getResponse(): ResponseInterface;
}