<?php
namespace src\models;

final class UzivateleTokenModel extends Model{

    public string $primaryKey = "Uzivatele_Id";
    protected string $table = 'Uzivatele_Tokeny';
    protected string $query = "";
    public int $id;
    
    public array $assignables = [
        'token'         => 'string',
        'Uzivatele_Id'  => 'integer',
    ];

}