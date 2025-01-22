<?php
namespace src\validators;


class ZnamkaRequestValidator extends Validator{

    protected array $rules = [
        'id'         => 'integer',
        'znamka'     => 'integer',
        'poznamka'   => 'string',
        'zapsano'    => 'string',
    ];

    protected function getRules($request): void {
        if ($request->server["request_method"] == 'POST')
            array_push($this->rules, [
                'Studenti_Id' => 'integer|required',
                'Predmety_Id' => 'integer|required',
        ]);
    }
}

?>