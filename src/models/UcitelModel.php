<?php
namespace src\models;

final class UcitelModel extends Model{
    
    public string $primaryKey = 'id';
    protected string $table = 'Ucitele';
    protected string $query = "";
    public int $id;
    
    public array $assignables = [
        'jmeno'     => 'string',
        'trida_Id'  => 'integer',
    ];

}