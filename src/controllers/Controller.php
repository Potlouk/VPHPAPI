<?php
namespace src\controllers;

use src\interfaces\ControllerInterface;
use src\interfaces\ModelDTOInterface;
use src\requests\ApiRequest;
use src\services\CollectionService;
use src\traits\CanRespond;
use src\validators\Validator;
use Swoole\Http\Response;

class Controller implements ControllerInterface{
  use CanRespond;
    protected Response $response;

    public function __construct(
        private CollectionService $modelService,
        private ModelDTOInterface $modelDTO, 
        private Validator $requestValidator,
        Response $response
        ) {
          $this->response = $response;
          
    }

    public function get(ApiRequest $request): void{
        $vRequest = $this->requestValidator->validate($request);
        $result = $this->modelService->get($vRequest);
        $result = $this->modelDTO->transform($result);
        $this->response($result);
     }
 
     public function create(ApiRequest $request): void{
       $vRequest = $this->requestValidator->validate($request);
       $modelId = $this->modelService->create($vRequest);
       $this->response($modelId);
     }
 
     public function patch(ApiRequest $request): void{
       $vRequest = $this->requestValidator->validate($request);
       $this->modelService->patch($vRequest);
       $this->response();
     }
 
     public function delete(ApiRequest $request): void{
       $vRequest = $this->requestValidator->validate($request);
       $this->modelService->delete($vRequest);
       $this->response();
     }
 
     public function paginate(ApiRequest $request): void{
       $vRequest = $this->requestValidator->validate($request);
       $result = $this->modelService->paginate($vRequest);
       $this->response(json_encode($result));
     }
 
}
