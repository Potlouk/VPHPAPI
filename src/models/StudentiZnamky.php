<?php
namespace src\models;

final class StudentiZnamky extends Model{
    
    public string $primaryKey = 'id';
    protected string $table = 'Studenti_Znamky';
    protected string $query = "";
    public int $id;
    
    public array $assignables = [
        'Predmety_Id'   => 'integer',
        'Znamky_Id'     => 'integer',
        'Studenti_Id'   => 'integer',
    ];

}