<?php

namespace Basic\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Basic\Interface\BasicControllerInterface;

class Frontpage implements BasicControllerInterface
{
    public function getResponse(string $name = '', string $lastname = ''): ResponseInterface
    {
        return new Response(200, ['Content-Type' => 'text/html'], 'velkommen til forsiden... ' . $name . ' ' . $lastname);
    }
}
