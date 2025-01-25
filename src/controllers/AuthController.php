<?php
namespace src\controllers;

use src\requests\ApiRequest;
use src\services\AuthService;
use Swoole\Http\Response;

class AuthController extends Controller{
   
    public function __construct(
        private AuthService $auth,
        Response $response
    ) {
        $this->response = $response;
    }

    public function login(ApiRequest $request) : void {
        $userAuth = $this->auth->login($request->data);
        $this->responseCookie($userAuth);     
    }

    public function register(ApiRequest $request) : void {
        $userAuth = $this->auth->register($request->data);
        $this->responseCookie($userAuth);  
    }

}