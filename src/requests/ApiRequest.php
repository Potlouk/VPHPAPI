<?php
namespace src\requests;

use src\models\Model;
use Swoole\Http\Request;

class ApiRequest extends Request{
    public array $data;
    public Model $auth;
    private parent $parent;

    public function rawContent(): string | false{
        $pData = $this->parent->rawContent();
        unset($this->parent);
        return $pData;
    }

    public function __construct(parent $request)
    {   
        $this->parent = $request;

        foreach ($request as $key => $value) 
        $this->$key = $value;
    }

}