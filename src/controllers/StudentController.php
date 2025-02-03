<?php
namespace src\controllers;

use src\DTO\StudentDTO;
use src\services\StudentService;
use src\validators\studentRequestValidator;
use Swoole\Http\Response;

final class StudentController extends Controller{
    public function __construct(
        private StudentService $student,
        private StudentDTO $studentDTO, 
        private studentRequestValidator $requestValidator,
        Response $response
        ) {
       parent::__construct($student,$studentDTO,$requestValidator,$response);
    }
 
}