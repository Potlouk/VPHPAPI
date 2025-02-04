<?php
namespace src\controllers;

use src\DTO\PredmetDTO;
use src\services\PredmetService;
use src\validators\PredmetRequestValidator;
use Swoole\Http\Response;

final class PredmetController extends Controller{
   
    public function __construct(
        private PredmetService $predmet,
        private PredmetDTO $predmetDTO,
        private PredmetRequestValidator $requestValidator,
        Response $response
    ){
        parent::__construct($predmet,$predmetDTO,$requestValidator,$response);
    }

}