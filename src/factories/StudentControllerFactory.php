<?php
namespace src\factories;

use src\interfaces\FactoryControllerInterface;
use src\controllers\StudentController;
use src\DTO\StudentDTO;
use src\services\StudentService;
use src\validators\studentRequestValidator;
use Swoole\Http\Response;

final class StudentControllerFactory implements FactoryControllerInterface {
    
    public static function build(Response $response): StudentController {
        return new StudentController(
            new StudentService,
            new StudentDTO,
            new studentRequestValidator,
            $response
        );
    }

}