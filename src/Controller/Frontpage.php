<?php
declare(strict_types=1);
namespace Basic\Controller;

use Basic\Interface\BasicControllerInterface;
use Basic\RequestDTO\FrontpageRequestDTO;

class Frontpage implements BasicControllerInterface
{
    public function __construct(private readonly string $template = 'frontpage.latte')
    {
    }

    public function getResponse(FrontpageRequestDTO $frontpageRequestDTO = null): array
    {
       return ['greeting' => 'Welcome on the frontpage... :)'];
    }

    public function getTemplate(): string
    {
        return $this->template;
    }
}
