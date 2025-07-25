<?php
declare(strict_types = 1);
namespace Basic\RequestDTO;

use Basic\Interface\RequestDTOFactoryInterface;
use Basic\Interface\RequestDTOInterface;
use Exception;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionClass;

class RequestDTOFactory implements RequestDTOFactoryInterface
{

    public function map(ServerRequestInterface $server_request, string $requestDTO): RequestDTOInterface
    {

        $requestData = $this->unpackRequestParams(server_request: $server_request);

        try {
            $reflectionClass = new ReflectionClass($requestDTO);
            $uninitializedRequestDTO = $reflectionClass->newInstanceWithoutConstructor();
            $requestDTO = $uninitializedRequestDTO::fromArray($requestData);
        } catch (Exception $exception) {
            // custom error handler here...
            echo $exception->getMessage();
            exit;
        }

        return $requestDTO;
    }

    private function unpackRequestParams(ServerRequestInterface $server_request): array
    {
        $method = $server_request->getMethod();

        return match ($method) {
            'GET' => $server_request->getQueryParams(),
            'POST' => is_array($server_request->getParsedBody()) ? $server_request->getParsedBody() : [],
        };
    }
}