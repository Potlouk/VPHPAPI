<?php
namespace src\interfaces;

use src\requests\ApiRequest;

interface MiddlewareInterface{
    public static function resolve(ApiRequest &$request): void;
    
}