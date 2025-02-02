<?php
namespace src\factories;

use src\interfaces\FactoryControllerInterface;
use src\controllers\ZnamkaController;
use src\DTO\ZnamkaDTO;
use src\services\ZnamkyService;
use src\validators\ZnamkaRequestValidator;
use Swoole\Http\Response;

class ZnamkaControllerFactory implements FactoryControllerInterface {
    
    public static function build(Response $response): ZnamkaController {
        return new ZnamkaController(
            new ZnamkyService,
            new ZnamkaDTO,
            new ZnamkaRequestValidator,
            $response
        );
    }

}