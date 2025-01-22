<?php
namespace src\interfaces;

interface ModelRequestValidatorInterface{
    public function validate(array $request): array;    
}