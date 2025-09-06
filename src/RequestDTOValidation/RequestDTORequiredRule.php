<?php

namespace Basic\RequestDTOValidation;

use Basic\Interface\RequestDTOValidatorRuleInterface;
use InvalidArgumentException;
use ReflectionParameter;

class RequestDTORequiredRule implements RequestDTOValidatorRuleInterface
{

    public function handle(ReflectionParameter $parameter, array $requestData, callable $next): void
    {
        $paramName = $parameter->getName();
        $hasValue = $requestData[$paramName] ?? null;

        ($hasValue === null && $parameter->isOptional() === false)
            && throw new InvalidArgumentException('Missing required parameter: ' . $paramName);

        $next($parameter, $requestData);
    }
}
