<?php
declare(strict_types=1);
namespace Basic\RequestDTOValidation;

use Basic\Interface\RequestDTOValidatorRuleInterface;
use Exception;
use ReflectionParameter;

class RequestDTONullableRule implements RequestDTOValidatorRuleInterface
{

    public function handle(ReflectionParameter $parameter, array $requestData, callable $next): void
    {
        $paramName = $parameter->getName();
        $paramType = $parameter->getType();

        $hasValue = $requestData[$paramName] ?? null;

        if ($hasValue === null && $paramType?->allowsNull()) {
            return;
        }

        $next($parameter, $requestData);
    }
}
