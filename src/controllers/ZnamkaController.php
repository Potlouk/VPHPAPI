<?php
namespace src\controllers;

use src\DTO\ZnamkaDTO;
use src\services\ZnamkyService;
use src\validators\ZnamkaRequestValidator;
use Swoole\Http\Response;

class ZnamkaController extends Controller{
    public function __construct(
        private ZnamkyService $znamka,
        private ZnamkaDTO $znamkaDTO, 
        private ZnamkaRequestValidator $requestValidator,
        Response $response
        ) {
       parent::__construct($znamka,$znamkaDTO,$requestValidator,$response);
    }

}