<?php
namespace src;

use src\actions\MiddlewareConvertAction;
use src\DTO\RequestDTO;
use src\Enums\ErrorTypes;
use src\requests\ApiRequest;
use src\traits\ApiException;
use Swoole\Http\Response;

final class Router {

    private array $routes = [[[]]];
    private Path $lastRoute;

    public function __construct() {}

    public function route(string $path, string $request, string $controller, string $callback): self {
        $nArgs = 0;
        $urlParams = $this->buildUrlParams($path,$nArgs);

        $this->routes[$request][$nArgs][$path] = new Path($path, $controller, $callback, $urlParams);
        $this->lastRoute = &$this->routes[$request][$nArgs][$path];
        return $this;
    }

    public function middleware(array $middlewares): void{
        $this->lastRoute->middleware = array_merge(
            $this->lastRoute->middleware,
            $middlewares
        );
    }
   

    public function resolve(ApiRequest $request, Response $response): mixed {
        $requestMethod  = $request->server["request_method"];
        $requestPath    = $request->server["request_uri"];

        if (!$requestMethod || !$requestPath)
        ApiException::throw(ErrorTypes::EMPTY_REQUEST);
        if (!array_key_exists($requestMethod,$this->routes))
        ApiException::throw(ErrorTypes::UNKNOWN_METHOD);
    
        $endpoint = $this->matchPath(
            $this->routes[$requestMethod],
            $requestPath
        );
     
        $urlData = $this->extractUrlParams(
            $requestPath, 
            $endpoint->urlData
        );

       $request->data = RequestDTO::transform($request,$urlData);

        foreach ($endpoint->middleware as $middleware){
            $cMiddleware = MiddlewareConvertAction::convert($middleware);
            if (!$cMiddleware) {
                ApiException::logError("Middleware: {$middleware} not found.");
                continue;
            }
            $cMiddleware::resolve($request);
        }
        
        return call_user_func([
            $endpoint->controller::build($response),
            $endpoint->callback,
        ], $request);

    }

    private function matchPath($searchArray, $requestPath): Path {
        $nArgs = substr_count($requestPath,'/');
        foreach (array_keys($searchArray[$nArgs]) as $path){
            if (substr_count($path,'/') != $nArgs) continue;

            $matched = false;
            foreach(explode('/',$path) as $part){
                if ($part) continue;
                    if (!str_contains($requestPath,$part)){
                        $matched = false;
                        break;
                    }
                $matched = true;
            }
            if ($matched)
            return $searchArray[$nArgs][$path];
            
        }
        ApiException::throw(ErrorTypes::UNSUPPORTED_PATH);
    }

    private function buildUrlParams(string &$path, int &$nArgs): array {
        $nArgs = substr_count($path,'/');
        $aPath = explode('/', trim($path, '/'));
        $result = [];
        $index = 0;

        foreach ($aPath as $part){
            if (preg_match('/\{([^}]+)\}/', $part , $kl)){
                $result[$kl[1]] = $index;
                $path = str_replace('{'.$kl[1].'}', '', $path);
            }
            $index++;
        }
        return $result;
    }

    private function extractUrlParams(string $url, array $indexes): array {
        $params = [];
        $urlParts = explode('/', trim($url, '/'));
 
        foreach ($indexes as $index => $part) 
        $params[$index] = $urlParts[$part];
    
        return $params;
    }



}