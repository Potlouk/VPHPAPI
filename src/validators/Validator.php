<?php

namespace src\validators;
use src\Enums\ErrorTypes;
use src\interfaces\ModelRequestValidatorInterface;
use src\requests\ApiRequest;
use src\traits\ApiException;

abstract class Validator implements ModelRequestValidatorInterface{

    /**
     * @var array<string, mixed> Array containing request's requirements or sets them as passable data for any request.
     */
    protected array $rules = [];

    protected abstract function getRules(ApiRequest $request): void;

    /**
     * Validate request based on specified rules in validator
     *
     * @param ApiRequest $request
     * @return array<string, mixed> Array with matched keys of rules and request
     */
    public function validate(ApiRequest $request): array{
        $this->getRules($request);

        $request = array_intersect_key($request->data,$this->rules);
        $passable = false;
        
        foreach ($request as $key => $value){
            $rValue = &$value;
            if (empty($this->rules[$key])) continue;
            foreach(explode('|', $this->rules[$key]) as $rule){
                
                if (str_contains($value,'required') && !array_key_exists($rule,$request))
                         ApiException::throw(ErrorTypes::REQUEST_REQUIREMENTS_NOT_MET);

                if (str_contains($rule, 'min') || str_contains($rule, 'max'))
                    if (!$this->validateRange($rule, $value))
                        ApiException::throw(ErrorTypes::INVALID_RANGE_NUMBER);
                    
                if ($this->checkType($value,$rule)){
                    settype($rValue,$rule);
                    $passable = true;
                }
            }

            if (!$passable)
            ApiException::throw(
                ErrorTypes::WRONG_DATA_TYPE,
                ["{$key}" => $this->rules["{$key}"]]
            );
            else $passable = false;
        
        }

        return $request;
    }

    private function validateRange(string $valueA, string $valueB): bool{
        $x = (int) $valueB;
        $y = (int) explode(':',$valueA)[1];

        if (str_contains($valueA,'min')) return $x >= $y;
        else return $x <= $y;
    }

    private function checkType(mixed $value, string $type): bool {
       return match ($type) {
            'integer'   => is_int($value) || (is_string($value) && ctype_digit($value)),
            'string'    => is_string($value),
            'boolean'   => is_bool($value) || $value === '0' || $value === '1',
            'array'     => is_array($value),
            'float'     => is_float($value) || (is_string($value) && is_numeric($value)),
            default     => false
        };
    }

}