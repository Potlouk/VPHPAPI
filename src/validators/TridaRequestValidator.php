<?php
namespace src\validators;

use src\requests\ApiRequest;

final class TridaRequestValidator extends Validator{

    protected array $rules = [
        'nazev'     => 'string',
        'id'        => 'integer',
        'limit'     => 'integer|min:1',
        'current'   => 'integer|min:1',
    ];

    protected function getRules(ApiRequest $request): void {
        if (in_array($request->method, ['PATCH', 'DELETE','POST']))
        $this->rules = array_merge($this->rules, [
                'id' => 'integer|required',
        ]);
    }
}