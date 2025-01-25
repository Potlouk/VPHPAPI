<?php
namespace src\interfaces;

use src\requests\ApiRequest;

interface ModelRequestValidatorInterface{
    public function validate(ApiRequest $request): array;    
}