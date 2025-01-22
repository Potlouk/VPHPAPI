<?php
namespace src\factories;

use src\models\Uzivatel;

class UzivatelFactory extends ModelFactory{

    public static function build(array $array = []){
     return parent::make(new Uzivatel(), $array);
    }
    
}