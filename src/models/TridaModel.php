<?php
namespace src\models;

final class TridaModel extends Model{
    
    public string $primaryKey = 'id';
    protected string $table = 'Tridy';
    protected string $query = "";
    public int $id;
    
    public array $assignables = [
        'nazev' => 'string',
    ];
 
}