<?php
declare(strict_types=1);
namespace Basic\RequestDTO;

use Basic\Interface\RequestDTOInterface;
use InvalidArgumentException;

class FrontpageRequestDTO implements RequestDTOInterface
{

    private function __construct(private readonly string $firstname, private readonly bool $validated)
    {
    }

    public static function fromArray(array $data): FrontpageRequestDTO
    {
        $data = self::validateData($data);

        return new self($data['firstname'], $data['validated']);
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    private static function validateData(array $data): array
    {
        $data['firstname'] ?? throw new InvalidArgumentException('First name is required');

        return $data;
    }

}
