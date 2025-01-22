<?php
namespace src\traits;

trait CanRespond {
    protected function response(mixed $data = 'ok', int $code = 200){
        $this->response->header('Content-Type','application/json');
        $this->response->status($code);
        $this->response->write($data);
        $this->response->end();
    }

    protected function responseCookie(mixed $data = 'ok', int $code = 200){
        $this->response->header('Content-Type','application/json');
        $this->response->status($code);
        $this->response->write($data);
        $this->response->end();
    }
}

?>