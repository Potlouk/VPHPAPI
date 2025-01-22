<?php
namespace src\middlewares;

use src\Enums\ErrorTypes;
use src\interfaces\MiddlewareInterface;
use src\requests\ApiRequest;
use src\traits\ApiException;
use src\traits\Auth;

final class SelfCheckMiddleware implements MiddlewareInterface {
 use Auth;
    
    static function resolve(ApiRequest &$request): void {
        if($request->auth->Studenti_Id != $request->data['id'] && !$request->auth->Ucitele_Id)
            ApiException::throw(ErrorTypes::UNAUTHORIZED, [] , 401);
    }
}

?>