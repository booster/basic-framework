<?php

namespace Basic\Controller;

use Basic\Interface\BasicControllerInterface;
use Basic\RequestDTO\NewContractRequestDTO;

class NewContact implements BasicControllerInterface
{

    public function getResponse(NewContractRequestDTO $requestDTO = null): array
    {
        return ['status' => 200, 'message' => 'Contact created: ' . $requestDTO->getFullName()];
    }
}