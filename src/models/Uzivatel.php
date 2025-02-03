<?php
namespace src\models;

final class Uzivatel extends Model{
    
    public string $primaryKey = 'id';
    protected string $table = 'Uzivatele';
    protected string $query = "";
    public int $id;
    
    public array $assignables = [
        'jmeno'         => 'string',
        'heslo'         => 'string',
        'Studenti_Id'   => 'null',
        'Ucitele_Id'    => 'null',
    ];

    public array $relations = [
        'token' => ['one' => [ UzivateleTokenModel::class ]],
    ];

}