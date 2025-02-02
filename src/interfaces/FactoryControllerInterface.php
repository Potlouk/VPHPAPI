<?php
namespace src\interfaces;

use src\controllers\Controller;
use Swoole\Http\Response;

interface FactoryControllerInterface{
    public static function build(Response $response): Controller;
}