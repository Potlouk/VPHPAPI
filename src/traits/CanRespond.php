<?php
namespace src\traits;

trait CanRespond {
    protected function response(mixed $data = 'ok', int $code = 200){
        $this->response->header('Content-Type','application/json');
        $this->response->status($code);
        $this->response->write($data);
        $this->response->end();
    }

    protected function responseCookie(array $cookies,mixed $data = 'ok', int $code = 200){
        $this->response->header('Content-Type','application/json');
        foreach ($cookies as $key => $value)
        $this->response->cookie($key, $value);
        $this->response->status($code);
        $this->response->write($data);
        $this->response->end();
    }
}

?>