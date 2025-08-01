<?php
declare(strict_types=1);
namespace Basic\RequestDTO;

use Basic\Interface\RequestDTOInterface;

class FrontpageRequestDTO implements RequestDTOInterface
{

    private function __construct()
    {
    }

    public static function fromArray(): FrontpageRequestDTO
    {
        return new self();
    }
}
