<?php
namespace src\models;

class ZnamkaModel extends Model{
    public string $primaryKey = 'id';
    protected string $table = 'Znamky';
    protected string $query = "";
    public int $id;
    
    public array $assignables = [
        'poznamka' => 'string',
        'zapsano' => 'string',
        'znamka' => 'integer',
    ];

    public array $relations = [
      
    ];


}