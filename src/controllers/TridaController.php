<?php
namespace src\controllers;

use src\DTO\TridaDTO;
use src\services\TridaService;
use src\validators\TridaRequestValidator;
use Swoole\Http\Response;

final class TridaController extends Controller{
   
    public function __construct(
        private TridaService $trida,
        private TridaDTO $tridaDTO,
        private TridaRequestValidator $requestValidator,
        Response $response
    ) {
        parent::__construct($trida,$tridaDTO,$requestValidator,$response);
    }

}