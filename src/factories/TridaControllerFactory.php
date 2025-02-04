<?php
namespace src\factories;

use src\interfaces\FactoryControllerInterface;
use src\controllers\TridaController;
use src\DTO\TridaDTO;
use src\services\TridaService;
use src\validators\TridaRequestValidator;
use Swoole\Http\Response;

final class TridaControllerFactory implements FactoryControllerInterface {
    
    public static function build(Response $response): TridaController {
        return new TridaController(
            new TridaService,
            new TridaDTO,
            new TridaRequestValidator,
            $response
        );
    }

}