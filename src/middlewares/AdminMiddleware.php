<?php
namespace src\middlewares;

use src\Enums\ErrorTypes;
use src\interfaces\MiddlewareInterface;
use src\requests\ApiRequest;
use src\traits\ApiException;
use src\traits\Auth;

final class AdminMiddleware implements MiddlewareInterface {
    use Auth;
    static function resolve(ApiRequest &$request): void {
        if(!self::isAdmin($request->auth))
        ApiException::throw(ErrorTypes::UNAUTHORIZED, [], 401);
    }

}
?>