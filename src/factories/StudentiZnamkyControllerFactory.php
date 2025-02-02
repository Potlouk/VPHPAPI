<?php
namespace src\factories;

use src\interfaces\FactoryControllerInterface;
use src\controllers\StudentiZnamkyController;
use src\DTO\StudentiZnamkyDTO;
use src\services\StudentiZnamkyService;
use src\validators\StudentiZnamkyValidator;
use Swoole\Http\Response;

class StudentiZnamkyControllerFactory implements FactoryControllerInterface {
    
    public static function build(Response $response): StudentiZnamkyController {
        return new StudentiZnamkyController(
            new StudentiZnamkyService,
            new StudentiZnamkyDTO,
            new StudentiZnamkyValidator,
            $response
        );
    }

}