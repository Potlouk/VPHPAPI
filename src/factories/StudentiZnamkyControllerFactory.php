<?php
namespace src\factories;

use src\interfaces\FactoryControllerInterface;
use src\controllers\StudentiZnamkyController;
use src\DTO\StudentiZnamkyDTO;
use src\services\StudentiZnamkyService;
use src\validators\StudentiZnamkyValidator;

class StudentiZnamkyControllerFactory implements FactoryControllerInterface {
    
    public static function build($response): StudentiZnamkyController {
        return new StudentiZnamkyController(
            new StudentiZnamkyService,
            new StudentiZnamkyDTO,
            new StudentiZnamkyValidator,
            $response
        );
    }

}