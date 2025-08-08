<?php

namespace Basic\Responder;

use Basic\Interface\ResponderInterface;
use Basic\ResponseTypes\Type;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class JsonResponder implements ResponderInterface
{

    public function respond(ServerRequestInterface $request, array $content, string $template): ResponseInterface
    {
        return new Response(200, ['Content-Type' => Type::JSON->value], json_encode($content));
    }
}