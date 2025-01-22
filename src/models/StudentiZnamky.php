<?php
namespace src\models;

class StudentiZnamky extends Model{
    public string $primaryKey = 'id';
    protected string $table = 'Studenti_Znamky';
    protected string $query = "";
    public int $id;
    
    public $assignables = [
        'Predmety_Id' => 'integer',
        'Znamky_Id' => 'integer',
        'Studenti_Id' => 'integer',
    ];

    
}