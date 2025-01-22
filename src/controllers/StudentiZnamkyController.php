<?php
namespace src\controllers;

use src\DTO\StudentiZnamkyDTO;
use src\services\StudentiZnamkyService;
use src\validators\StudentiZnamkyValidator;
use Swoole\Http\Response;

class StudentiZnamkyController extends Controller{
    public function __construct(
        private StudentiZnamkyService $znamka,
        private StudentiZnamkyDTO $znamkaDTO, 
        private StudentiZnamkyValidator $requestValidator,
        Response $response
        ) {
       parent::__construct($znamka,$znamkaDTO,$requestValidator,$response);
    }



}