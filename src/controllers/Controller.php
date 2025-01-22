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
        $result = $this->modelService->get($request->data);
        $result = $this->modelDTO->transform($result);
        $this->response($result);
     }
 
     public function create(ApiRequest $request): void{
       $request = $this->requestValidator->validate($request->data);
       $modelId = $this->modelService->create($request);
       $this->response($modelId);
     }
 
     public function patch(ApiRequest $request): void{
       $request = $this->requestValidator->validate($request->data);
       $this->modelService->patch($request);
       $this->response();
     }
 
     public function delete(ApiRequest $request): void{
       $request = $this->requestValidator->validate($request->data);
       $this->modelService->delete($request);
       $this->response();
     }
 
     public function paginate(ApiRequest $request): void{
       $request = $this->requestValidator->validate($request->data);
       $result = $this->modelService->paginate($request);
       $this->response(json_encode($result));
     }
 
  
}
