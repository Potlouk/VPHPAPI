<?php
namespace src\models;

class PredmetModel extends Model{
    public string $primaryKey = 'id';
    protected string $table = 'Predmety';
    protected string $query = "";
    public int $id;
    
    public $assignables = [
        'nazev' => 'string',
        'poznamka' => 'string',
        'zapsano' => 'string',
    ];

    
}