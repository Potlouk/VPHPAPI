<?php
namespace src\factories;

use src\models\ZnamkaModel;

class ZnamkaModelFactory extends ModelFactory{

    public static function build(array $array = []){
        return parent::make(new ZnamkaModel(), $array);
    }
    
}