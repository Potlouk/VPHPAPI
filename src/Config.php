<?php
namespace src;

use src\Enums\ErrorTypes;
use src\middlewares\AdminMiddleware;
use src\middlewares\AuthMiddleware;
use src\middlewares\CorseMiddleware;
use src\middlewares\StudentMiddleware;
use src\middlewares\TeacherMiddleware;
use src\traits\ApiException;

final class Config {

    /**
    * @var array<string, class-string>
    */
    public static array $middlewareLookup = [
        'selfCheck'  => StudentMiddleware::class,
        'auth'       => AuthMiddleware::class,
        'private'    => CorseMiddleware::class,
        'onlyAdmin'  => AdminMiddleware::class,
        'onlyTeacher'=> TeacherMiddleware::class
    ];

    public static function getEnv(string $name): mixed {

        if (!array_key_exists($name, $_ENV))
            ApiException::throw(ErrorTypes::INTERNAL_SERVER_ERROR);

        return $_ENV[$name];
    }

}


