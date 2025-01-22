<?php
namespace src\factories;

use src\models\UzivateleTokenModel;

class TokenFactory extends ModelFactory{

    public static function build(array $array = []){
        return parent::make(new UzivateleTokenModel(), $array);
    }

}