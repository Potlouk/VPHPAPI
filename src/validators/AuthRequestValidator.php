<?php
namespace src\validators;

use src\requests\ApiRequest;

final class AuthRequestValidator extends Validator{

    protected array $rules = [
        'jmeno'       => 'string',
        'Studenti_Id' => 'integer|string',
        'Ucitele_Id'  => 'integer|string',
        'heslo'        => 'string'
    ];

    protected function getRules(ApiRequest $request): void {
        if (in_array($request->method, ['POST']))
        $this->rules = array_merge($this->rules, [
                'jmeno' => 'string|required',
                'heslo' => 'string|required'
        ]);
    }

}