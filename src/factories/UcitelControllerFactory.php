<?php
namespace src\factories;

use src\interfaces\FactoryControllerInterface;
use src\controllers\UcitelController;
use src\DTO\ModelDTO;
use src\services\UcitelService;
use src\validators\UcitelRequestValidator;
use Swoole\Http\Response;

final class UcitelControllerFactory implements FactoryControllerInterface {
    
    public static function build(Response $response): UcitelController {
        return new UcitelController(
            new UcitelService,
            new ModelDTO,
            new UcitelRequestValidator,
            $response
        );
    }

}