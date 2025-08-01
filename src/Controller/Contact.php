<?php
declare(strict_types=1);
namespace Basic\Controller;

use Basic\Interface\BasicControllerInterface;

class Contact implements BasicControllerInterface
{
    public function __construct(public string $template = 'contact.template')
    {
    }

    public function getResponse(): array
    {
        return ['greeting' => 'Hello there '];
    }
}
