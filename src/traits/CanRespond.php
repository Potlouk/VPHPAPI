<?php
namespace src\traits;

trait CanRespond {

    private string $responseFormat = '{
        "status" : "success",
        "message": "Request completed successfully",
    ';

    protected function response(mixed $data = [], int $code = 200){
        $this->appendData($data);
        $this->response->header('Content-Type','application/json');
        $this->response->status($code);
        $this->response->write($this->responseFormat);
        $this->response->end();
    }

    protected function responseCookie(array $cookies, mixed $data = 'ok', int $code = 200){
        $this->response->header('Content-Type','application/json');
        foreach ($cookies as $key => $value)
        $this->response->cookie($key, $value);
        $this->response->status($code);
        $this->response->write($data);
        $this->response->end();
    }


    private  function appendData(mixed $data): void {
        $this->responseFormat .= '"data" :';
        
        if (is_array($data))
        $this->responseFormat .= json_encode($data);
        else $this->responseFormat .= $data;

        $this->responseFormat .= '}';
    }
}

?>