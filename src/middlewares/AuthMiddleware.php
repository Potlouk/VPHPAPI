<?php
namespace src\middlewares;

use src\Enums\ErrorTypes;
use src\factories\UzivatelFactory;
use src\interfaces\MiddlewareInterface;
use src\models\Uzivatel;
use src\models\UzivateleTokenModel;
use src\requests\ApiRequest;
use src\traits\ApiException;
use src\traits\Auth;


final class AuthMiddleware implements MiddlewareInterface {
    use Auth;
    static function resolve(ApiRequest &$request): void {

        if (!is_array($request->cookie) || !array_key_exists('token', $request->cookie))
            ApiException::throw(ErrorTypes::AUTH_COOKIE_NOT_PASSED);

        if (!array_key_exists('user_id',$request->cookie) || !array_key_exists('token',$request->cookie))
            ApiException::throw(ErrorTypes::AUTH_COOKIE_NOT_SATISFIED);
        
        $auth = new UzivateleTokenModel();
        $auth = $auth->find($request->cookie['user_id']);

        if (empty($auth))
            ApiException::throw(ErrorTypes::UNKNOWN_USER);
        
        if (!self::isMatchingToken($request->cookie['token'], $auth['token']))
            ApiException::throw((ErrorTypes::USER_WRONG_TOKEN));

        $user = new Uzivatel();
        $user = $user->find($request->cookie['user_id']);

        $request->auth = UzivatelFactory::build($user);
    }
    
}
