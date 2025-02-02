<?php
namespace src\interfaces;

use src\requests\ApiRequest;

interface ModelRequestValidatorInterface{
    /**
    * @return array<string, mixed>
    */
    public function validate(ApiRequest $request): array;    
}