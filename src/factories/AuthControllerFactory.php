<?php
namespace src\factories;

use src\controllers\AuthController;
use src\interfaces\FactoryControllerInterface;
use src\services\AuthService;

class AuthControllerFactory implements FactoryControllerInterface {

    public static function build($response): AuthController {
        return new AuthController(
            new AuthService,
            $response
        );
    }

}