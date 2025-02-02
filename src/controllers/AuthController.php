<?php
namespace src\controllers;

use src\requests\ApiRequest;
use src\services\AuthService;
use src\validators\AuthRequestValidator;
use Swoole\Http\Response;

class AuthController extends Controller{
   
    public function __construct(
        private AuthService $auth,
        private AuthRequestValidator $validator,
        Response $response
    ) {
        $this->response = $response;
    }

    public function login(ApiRequest $request) : void {
        $request = $this->validator->validate($request);
        $credentials = $this->auth->login($request);
        $this->responseCookie($credentials);     
    }

    public function register(ApiRequest $request) : void {
        $request = $this->validator->validate($request);
        $credentials = $this->auth->register($request);
        $this->responseCookie($credentials);  
    }

}