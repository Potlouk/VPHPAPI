<?php
namespace src\requests;

use src\models\Model;
use Swoole\Http\Request;

class ApiRequest extends Request{
    public array $data;
    public Model $auth;

    public function __construct(parent $request)
    {
        foreach ($request as $key => $value) 
        $this->$key = $value;
    }

}