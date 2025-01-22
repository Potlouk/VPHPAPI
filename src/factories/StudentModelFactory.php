<?php
namespace src\factories;

use src\models\StudentModel;

class StudentModelFactory extends ModelFactory{

    public static function build(array $array = []){
        return parent::make(new StudentModel(), $array);
    }

}