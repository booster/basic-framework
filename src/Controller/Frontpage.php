<?php
declare(strict_types=1);
namespace Basic\Controller;

use Basic\Interface\BasicControllerInterface;
use Basic\Interface\RequestDTOInterface;

class Frontpage implements BasicControllerInterface
{
    public function __construct(string $template = 'frontpage')
    {
    }

    public function getResponse(): array
    {
       return ['greeting' => 'Welcome on the frontpage... :)'];
    }
}
