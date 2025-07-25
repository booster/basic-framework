<?php
declare(strict_types=1);
namespace Basic\RequestDTO;

use Basic\Interface\RequestDTOInterface;
use InvalidArgumentException;

class FrontpageRequestDTO implements RequestDTOInterface
{

    private function __construct(private string $firstname)
    {
    }

    public static function fromArray(array $data): FrontpageRequestDTO
    {
        $data = self::validateData($data);

        return new self($data['firstname']);
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
