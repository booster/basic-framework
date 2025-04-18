<?php
declare(strict_types=1);
namespace Basic\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Basic\Interface\BasicControllerInterface;

class Frontpage implements BasicControllerInterface
{
    public function __construct(string $template = 'frontpage')
    {
    }

    public function getResponse(string $firstname = '', string $lastname = ''): ResponseInterface
    {
        return new Response(200, ['Content-Type' => 'text/html'], 'Velkommen på forsiden...' . $firstname . ' ' . $lastname);
    }
}
