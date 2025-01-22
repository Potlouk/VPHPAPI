<?php
namespace src;

use src\Enums\ErrorTypes;
use src\middlewares\AuthMiddleware;
use src\middlewares\SelfCheckMiddleware;
use src\traits\ApiException;

final class Config {

    public static array $middlewareLookup = [
        'selfCheck' => SelfCheckMiddleware::class,
        'auth'      => AuthMiddleware::class,

    ];

    public static function getEnv(string $name): mixed {

        if (!array_key_exists($name, $_ENV))
            ApiException::throw(ErrorTypes::INTERNAL_SERVER_ERROR);

        return $_ENV[$name];
    }

}


