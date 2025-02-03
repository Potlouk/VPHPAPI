<?php
namespace src\controllers;

use src\DTO\ModelDTO;
use src\services\UcitelService;
use src\validators\Validator;
use Swoole\Http\Response;

final class UcitelController extends Controller{
    public function __construct(
        private UcitelService $student,
        private ModelDTO $studentDTO, 
        private Validator $requestValidator,
        Response $response
        ) {
       parent::__construct($student,$studentDTO,$requestValidator,$response);
    }

}