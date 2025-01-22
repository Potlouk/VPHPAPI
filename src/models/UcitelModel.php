<?php
namespace src\models;

class UcitelModel extends Model{
    public string $primaryKey = 'id';
    protected string $table = 'Ucitele';
    protected string $query = "";
    public int $id;
    
    public $assignables = [
        'jmeno' => 'string',
        'trida_Id' => 'integer',
    ];

    
}