<?php

namespace Basic\Interface;

use Basic\RequestDTOValidation\RequestDTOValidator;
use ReflectionParameter;

interface RequestDTOValidatorRuleInterface
{
    public function handle(ReflectionParameter $parameter, array $requestData, callable $next): void;
}
