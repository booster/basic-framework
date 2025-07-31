<?php
declare(strict_types = 1);
namespace Basic\RequestDTO;

use Basic\Interface\BasicControllerInterface;
use Basic\Interface\RequestDTOFactoryInterface;
use Basic\Interface\RequestDTOInterface;
use Exception;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;

class RequestDTOFactory implements RequestDTOFactoryInterface
{

    public function map(ServerRequestInterface $server_request, BasicControllerInterface $controller): RequestDTOInterface
    {

        $requestData = $this->unpackRequestParams(server_request: $server_request);
        $requestDTO = $this->getRequestDTO(controller: $controller);

        try {
            $reflectionClass = new ReflectionClass($requestDTO);

            foreach ($reflectionClass->getConstructor()->getParameters() as $parameter) {
                $paramName = $parameter->getName();
                $paramType = $parameter->getType();
                $paramTypeName = $paramType?->getName();

                if (!$paramType instanceof ReflectionNamedType) {
                    continue; // Union types or complex types is skipped
                }

                $isNullable = $paramType->allowsNull();
                $hasValue = $requestData[$paramName] ?? null;

                if ($hasValue === null && $parameter->isOptional() === false) {
                    throw new InvalidArgumentException('Missing required parameter: ' . $paramName);
                }

                // Nullable and null is OK
                if ($hasValue === null && $isNullable) {
                    continue;
                }

                $requestDataType = get_debug_type($requestData[$paramName]);
                if ($hasValue !== null && $requestDataType !== $paramTypeName) {
                    throw new InvalidArgumentException('Parameter ' . $paramName . ' is wrong type, was expecting ' . $paramTypeName . ' but got ' . $requestDataType);
                }

                //$requestDataType = get_debug_type($requestData[$paramName]);
                //$requestDataType === $paramTypeName ?: throw new InvalidArgumentException('Parameter ' . $paramName . ' is wrong type, was expecting ' . $paramTypeName . ' but got ' . $requestDataType);
                // validate type of parameter to ensure correct match with contructor argument type.
            }

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
            //'POST' => is_array($server_request->getParsedBody()) ? $server_request->getParsedBody() : [],
            'POST' => $this->getPostBody(server_request: $server_request),
        };
    }

    private function getRequestDTO(BasicControllerInterface $controller): ?string
    {
        $reflection = new ReflectionMethod($controller, 'getResponse');
        $params = $reflection->getParameters();
        $requestDTO = !empty($params) ? $params[0]->getType()?->getName() : null;

        return  $requestDTO ?? class_exists($requestDTO ?? '') ? $requestDTO : null;
    }

    private function getPostBody(ServerRequestInterface $server_request): array
    {
        $content_type = $server_request->getHeaderLine('Content-Type');

        $content_types_parts = explode(';', $content_type);

        return match ($content_types_parts[0]) {
            'application/json' => json_decode($server_request->getBody()->getContents(), true),
            default => $server_request->getParsedBody(),
        };
    }
}
