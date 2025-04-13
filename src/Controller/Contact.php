<?php

namespace Basic\Controller;

use Basic\Interface\BasicControllerInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class Contact implements BasicControllerInterface
{

    public function getResponse(): ResponseInterface
    {
        return new Response(200, ['Content-Type' => 'text/html'], 'velkommen til kontaktsiden...');
    }
}
