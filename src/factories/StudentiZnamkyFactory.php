<?php
namespace src\factories;

use src\models\StudentiZnamky;

class StudentiZnamkyFactory extends ModelFactory{

    public static function build(array $array = []){
        return parent::make(new StudentiZnamky(), $array);
    }
    
}