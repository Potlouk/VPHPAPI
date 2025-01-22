<?php
namespace src;

use Dotenv\Dotenv;
use src\controllers\AuthController;
use src\controllers\ZnamkaController;
use src\factories\AuthControllerFactory;
use Swoole\Http\Server;
use src\factories\StudentControllerFactory;
use src\factories\StudentiZnamkyControllerFactory;
use src\factories\StudentiZnamkyFactory;
use src\factories\ZnamkaControllerFactory;
use src\Middlewares\AuthMiddleware;
use src\middlewares\ReadPermissionMiddleware;
use src\middlewares\SelfCheckMiddleware;
use src\requests\ApiRequest;
use src\Router;
use src\services\AuthService;
use src\services\ZnamkyService;
use src\traits\ApiException;
use ZnamkyMiddleware;

require_once dirname(__DIR__, 1).'/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->safeLoad();

$server = new Server(
  Config::getEnv('SERVER_IP'),
  Config::getEnv('SERVER_PORT'),
);
$router = new Router();


$server->on("start", function () use ($router) {
   $router->route('/student/{id}',              'GET',    StudentControllerFactory::class,'get');//->middleware(['auth','selfCheck']);
   
  // $router->addRoute('/student/{id}',              'GET',    StudentControllerFactory::class,'get');
  // $router->addRoute('/student/{current}/{limit}', 'GET',    StudentControllerFactory::class,'paginate');
 //  $router->addRoute('/student',                   'POST',   StudentControllerFactory::class,'create');
   //$router->addRoute('/student/{id}',              'DELETE', StudentControllerFactory::class,'delete');
   //$router->addRoute('/student/{id}',              'PATCH',  StudentControllerFactory::class,'patch');

  // $router->route('/znamka',                     'POST',    ZnamkaControllerFactory::class,'create')->middleware([AuthMiddleware::class]);
   //$router->route('/znamka/{id}',                'PATCH',   ZnamkaControllerFactory::class,'patch');
   //$router->route('/znamka/{id}',                'DELETE',  ZnamkaControllerFactory::class,'delete');

   //$router->route('/registrace', 'POST' , AuthControllerFactory::class, 'register');
 //  $router->route('/prihlaseni', 'POST' , AuthControllerFactory::class, 'login');



});

$server->on("request", function ($request, $response) use ($router) {
    
    $request = new ApiRequest($request); 
  
    try{ $router->resolve($request, $response); }
    catch(ApiException $e){
        $response->header('Content-Type','application/json');
        $response->status($e->getCode());
        $response->write($e->getMessage());
        $response->end();
    }
 
});

$server->start();