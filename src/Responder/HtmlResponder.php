<?php
declare(strict_types=1);

namespace Basic\Responder;

use Basic\Interface\ResponderInterface;
use Basic\ResponseTypes\Type;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HtmlResponder implements ResponderInterface
{

    public function respond(ServerRequestInterface $request, array $content): ResponseInterface
    {
        return new Response(200, ['Content-Type' => Type::HTML->value], implode(', ', $content));
    }
}