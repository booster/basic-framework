<?php
declare(strict_types=1);
namespace Basic\Controller;

use Basic\Interface\BasicControllerInterface;
use Basic\RequestDTO\FrontpageRequestDTO;

class Frontpage implements BasicControllerInterface
{
    public function __construct(string $template = 'frontpage')
    {
    }

    public function getResponse(FrontpageRequestDTO $requestDTO = null): array
    {
       return ['greeting' => 'Welcome on the frontpage... ' . $requestDTO->getFirstname() . ' :)'];
    }
}
