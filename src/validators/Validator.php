<?php

namespace src\validators;
use src\Enums\ErrorTypes;
use src\interfaces\ModelRequestValidatorInterface;
use src\requests\ApiRequest;
use src\traits\ApiException;

abstract class Validator implements ModelRequestValidatorInterface{

    /**
     * Array containing request's requirements or sets them as passable data for any request. 
     */
    protected array $rules = [];


    protected abstract function getRules($request): void;

    /**
     * Validate request based on specified rules in validator
     *
     * @param   $request
     * @return array array with matched keys of rules and request
     *
     */
    public function validate(ApiRequest $request): array{
        $this->getRules($request);
        $request = $request->data;
        $passable = false;
        $request = array_intersect_key($request,$this->rules);
        
        foreach ($request as $key => &$value){
            if (empty($this->rules[$key])) continue;
            foreach(explode('|', $this->rules[$key]) as $rule){
                if (str_contains($rule, 'min') || str_contains($rule, 'max'))
                    if (!$this->validateRange($rule, $value))
                        ApiException::throw(ErrorTypes::INVALID_RANGE_NUMBER);
                    
                    if ($this->checkType($value,$rule)){
                        settype($value,$rule);
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

        foreach($this->rules as $rule => $value)
            if (str_contains($value,'required') && !array_key_exists($rule,$request))
            ApiException::throw(ErrorTypes::REQUEST_REQUIREMENTS_NOT_MET);

        return $request;
    }


    private function validateRange(string $valueA, string $valueB): bool{
        $valueB = (int) $valueB;
        $valueA = (int) explode(':',$valueA)[1];

        if (str_contains($valueA,'min')) return $valueA >= $valueB;
        else return $valueA <= $valueB;
    }


    private function checkType($value, string $type): bool {
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