<?php
declare(strict_types=1);

namespace Basic\RequestDTOValidation;

use Basic\Interface\RequestDTOInterface;
use Basic\Interface\RequestDTOValidatorRuleInterface;
use Exception;
use ReflectionClass;
use ReflectionParameter;

class RequestDTOValidator
{
    /**
     * @var array<int, RequestDTOValidatorRuleInterface>
     */
    private array $rules;
    public function __construct(RequestDTOValidatorRuleInterface ...$rules)
    {
        $this->rules = $rules;
    }

    public function validate(string $requestDTO, array $requestData): RequestDTOInterface
    {
        try {
            $reflectionClass = new ReflectionClass($requestDTO);

            foreach ($reflectionClass->getConstructor()->getParameters() as $parameter) {
                $this->runValidationChain($parameter, $requestData);
            }

            $uninitializedRequestDTO = $reflectionClass->newInstanceWithoutConstructor();

            return $uninitializedRequestDTO::fromArray($requestData);

        } catch (Exception $exception) {
            echo $exception->getMessage();
            exit;
        }
    }

    private function runValidationChain(ReflectionParameter $parameter, array $requestData): void
    {
        $next = current($this->rules);

        if (key($this->rules) === null) {
            return;
        }

        next($this->rules);

        $next->handle($parameter, $requestData, function (ReflectionParameter $parameter, array $requestData): void {
            $this->runValidationChain($parameter, $requestData);
        });
    }
}
