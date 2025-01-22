<?php
namespace src\factories;

use src\models\UcitelModel;

class UcitelModelFactory extends ModelFactory{

    public static function build(array $array = []){
        return parent::make(new UcitelModel(), $array);
    }

}