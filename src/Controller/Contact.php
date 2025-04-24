<?php
declare(strict_types=1);
namespace Basic\Controller;

use Basic\Interface\BasicControllerInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class Contact implements BasicControllerInterface
{
    public function __construct(public string $template = 'contact.template')
    {
    }

    public function getResponse(string $firstname = ''): array
    {
        return ['greeting' => 'Hello there ' . $firstname];
    }
}
