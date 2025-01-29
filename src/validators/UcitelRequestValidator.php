<?php
namespace src\validators;


class UcitelRequestValidator extends Validator{

    protected array $rules = [
        'jmeno'     => 'string',
        'prijmeni'  => 'string',
        'id'        => 'integer|string',
        'limit'     => 'integer|min:1',
        'current'   => 'integer|min:1',
        'trida_Id'  => 'integer',
    ];

    protected function getRules($request): void {}
}