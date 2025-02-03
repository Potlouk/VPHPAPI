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
        //user can only work with its own model.
        'selfCheck'  => StudentMiddleware::class,
        
        //auth checkout.
        'auth'       => AuthMiddleware::class,
        
        //requests can be send only locally.
        'private'    => CorseMiddleware::class,

        //routes can accessed only be specified account type.
        'onlyAdmin'  => AdminMiddleware::class,
        'onlyTeacher'=> TeacherMiddleware::class
    ];

    public static function getEnv(string $name): mixed {

        if (!array_key_exists($name, $_ENV))
            ApiException::throw(ErrorTypes::INTERNAL_SERVER_ERROR);

        return $_ENV[$name];
    }

}