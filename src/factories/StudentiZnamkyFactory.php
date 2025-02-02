<?php
namespace src\factories;

use src\models\Model;
use src\models\StudentiZnamky;

class StudentiZnamkyFactory extends ModelFactory{
    /**
     * @param array<string, mixed> $array
     * @return Model
     */
    public static function build(array $array = []): Model {
        return parent::make(new StudentiZnamky(), $array);
    }
    
}