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
      
        $userToken = $this->auth->login($request->data);
        $this->response($userToken);   
    }

    public function register(ApiRequest $request) : void {
        $userToken = $this->auth->register($request->data);
        $this->response($userToken);  
    }

}