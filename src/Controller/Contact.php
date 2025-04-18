<?php
declare(strict_types=1);
namespace Basic\Controller;

use Basic\Interface\BasicControllerInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class Contact implements BasicControllerInterface
{

    public function getResponse(string $firstname = ''): ResponseInterface
    {
        return new Response(200, ['Content-Type' => 'application/json'], json_encode(['hej med dig ' . $firstname]));
    }
}
