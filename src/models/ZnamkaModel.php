<?php
namespace src\models;

class ZnamkaModel extends Model{
    public string $primaryKey = 'id';
    protected string $table = 'Znamky';
    protected string $query = "";
    public int $id;
    
    public $assignables = [
        'poznamka' => 'string',
        'zapsano' => 'string',
        'znamka' => 'integer',
    ];

    public $relations = [
        'predmet' => ['one' => PredmetModel::class ],
    ];


}