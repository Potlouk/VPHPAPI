<?php
namespace src\validators;

use src\requests\ApiRequest;

final class UcitelRequestValidator extends Validator{

    protected array $rules = [
        'jmeno'     => 'string',
        'prijmeni'  => 'string',
        'id'        => 'integer|string',
        'limit'     => 'integer|min:1',
        'current'   => 'integer|min:1',
        'trida_Id'  => 'integer',
    ];

    protected function getRules(ApiRequest $request): void {
        if (in_array($request->method, ['PATCH', 'DELETE']))
        $this->rules = array_merge($this->rules, [
                'id' => 'integer|required',
        ]);
    }
}