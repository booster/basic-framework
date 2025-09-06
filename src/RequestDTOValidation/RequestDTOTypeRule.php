<?php
declare(strict_types=1);
namespace Basic\RequestDTOValidation;

use Basic\Interface\RequestDTOValidatorRuleInterface;
use InvalidArgumentException;
use ReflectionParameter;

class RequestDTOTypeRule implements RequestDTOValidatorRuleInterface
{

    public function handle(ReflectionParameter $parameter, array $requestData, callable $next): void
    {
        $paramName = $parameter->getName();
        $paramType = $parameter->getType();
        $paramTypeName = $paramType?->getName();
        $hasValue = $requestData[$paramName] ?? null;

        $requestDataType = get_debug_type($requestData[$paramName]);
        if ($hasValue !== null && $requestDataType !== $paramTypeName) {
            throw new InvalidArgumentException('Parameter ' . $paramName . ' is wrong type, was expecting ' . $paramTypeName . ' but got ' . $requestDataType);
        }

        $next($parameter, $requestData);
    }
}
