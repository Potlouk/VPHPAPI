<?php
namespace src\models;

class Uzivatel extends Model{
    public string $primaryKey = 'id';
    protected string $table = 'Uzivatele';
    protected string $query = "";
    public int $id;
    
    public $assignables = [
        'heslo' => 'string',
        'Studenti_Id' => 'integer',
        'Ucitele_Id' => 'integer',
        'jmeno' => 'string'
    ];

    public $relations = [
        'token' => ['one' => UzivateleTokenModel::class ],
    ];

    
}