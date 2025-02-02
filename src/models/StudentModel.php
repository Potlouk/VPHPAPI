<?php
namespace src\models;

class StudentModel extends Model{
    public string $primaryKey = 'id';
    protected string $table = 'Studenti';
    protected string $query = "";
    public int $id;
    //rename
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