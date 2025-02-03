<?php
namespace src\traits;

trait CanRespond {

    private string $responseFormat = '{
        "status" : "success",
        "message": "Request completed successfully",
    ';
    
    /**
     * Sets body as part of the response.
     *
     * @param mixed $data .
     * @param int  $code  HTTP status code (default 200).
     */
    protected function response(mixed $data = [], int $code = 200): void {
        $this->appendData($data);
        $this->response->header('Content-Type','application/json');
        $this->response->status($code);
        $this->response->write($this->responseFormat);
        $this->response->end();
    }

    /**
     * Sets cookies as part of the response.
     *
     * @param array<string, mixed> $cookies An associative array of cookies.
     * @param mixed                $data    Optional data (default 'ok').
     * @param int                  $code    HTTP status code (default 200).
     */
    protected function responseCookie(array $cookies, mixed $data = 'ok', int $code = 200): void {
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