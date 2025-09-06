<?php
declare(strict_types=1);
namespace Basic\RequestDTO;

use Basic\Interface\RequestDTOInterface;

class FrontpageRequestDTO implements RequestDTOInterface
{

    private function __construct(private readonly ?string $firstname)
    {
    }

    public static function fromArray(array $data): FrontpageRequestDTO
    {
        return new self($data['firstname'] ?? '');
    }
}
