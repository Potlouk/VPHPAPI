<?php
namespace src\models;

class Uzivatel extends Model{
    public string $primaryKey = 'id';
    protected string $table = 'Uzivatele';
    protected string $query = "";
    public int $id;
    
    public array $assignables = [
        'heslo' => 'string',
        'Studenti_Id' => 'null',
        'Ucitele_Id' => 'null',
        'jmeno' => 'string'
    ];

    public array $relations = [
        'token' => ['one' => [ UzivateleTokenModel::class ]],
    ];

    
}