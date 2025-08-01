<?php

namespace Basic\RequestDTO;

use Basic\Interface\RequestDTOInterface;

class NewContractRequestDTO implements RequestDTOInterface
{
    private function __construct(private readonly string $firstname, private readonly string $lastname)
    {

    }
    public static function fromArray(array $data): NewContractRequestDTO
    {
        return new self(firstname: $data['firstname'], lastname: $data['lastname']);
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getFullname(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
