<?php
namespace src\factories;

use src\controllers\PredmetController;
use src\DTO\PredmetDTO;
use src\interfaces\FactoryControllerInterface;
use src\services\PredmetService;
use src\validators\PredmetRequestValidator;
use Swoole\Http\Response;

final class PredmetControllerFactory implements FactoryControllerInterface {
    
    public static function build(Response $response): PredmetController {
        return new PredmetController(
            new PredmetService,
            new PredmetDTO,
            new PredmetRequestValidator,
            $response
        );
    }

}