<?php
namespace src\middlewares;

use src\Config;
use src\Enums\ErrorTypes;
use src\interfaces\MiddlewareInterface;
use src\requests\ApiRequest;
use src\traits\ApiException;

final class CorseMiddleware implements MiddlewareInterface {

    static function resolve(ApiRequest &$request): void {
        $whiteList = [];
        array_push($whiteList, Config::getEnv('APP_INTERNAL_IP'));
        $clientIp = $request->server['remote_addr'];
   
        if (!in_array($clientIp, $whiteList))
        ApiException::throw(ErrorTypes::UNAUTHORIZED, [] ,401);
    }

}