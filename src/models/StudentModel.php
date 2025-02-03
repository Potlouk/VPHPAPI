<?php
namespace src\models;

final class StudentModel extends Model{
    
    public string $primaryKey = 'id';
    protected string $table = 'Studenti';
    protected string $query = "";
    public int $id;

    public array $assignables = [
        'jmeno'    => 'string',
        'prijmeni' => 'string',
        'trida'    => 'integer',
    ];

    public array $relations = [
        'predmety' => ['many'   => [ PredmetModel::class ]],
        'znamky'   => ['many'   => [ PredmetModel::class, ZnamkaModel::class ]],
        'trida'    => ['one'    => [ TridaModel::class ]],
    ];

}