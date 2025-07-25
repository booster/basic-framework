<?php
declare(strict_types=1);
namespace Basic\Interface;

use Psr\Http\Message\ResponseInterface;

interface BasicControllerInterface
{
    public function getResponse(): array;
}