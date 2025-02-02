<?php
namespace src\validators;

use src\requests\ApiRequest;

class ZnamkaRequestValidator extends Validator{

    protected array $rules = [
        'id'         => 'integer',
        'znamka'     => 'integer',
        'poznamka'   => 'string',
        'zapsano'    => 'string',
    ];

    protected function getRules(ApiRequest $request): void {
        if (in_array($request->method, ['POST']))
        $this->rules = array_merge($this->rules, [
                'Studenti_Id' => 'integer|required',
                'Predmety_Id' => 'integer|required',
        ]);
    }
}

?>