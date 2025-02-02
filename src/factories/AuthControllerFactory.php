<?php
namespace src\factories;

use src\controllers\AuthController;
use src\interfaces\FactoryControllerInterface;
use src\services\AuthService;
use src\validators\AuthRequestValidator;
use Swoole\Http\Response;

class AuthControllerFactory implements FactoryControllerInterface {

    public static function build(Response $response): AuthController {
        return new AuthController(
            new AuthService,
            new AuthRequestValidator,
            $response
        );
    }

}