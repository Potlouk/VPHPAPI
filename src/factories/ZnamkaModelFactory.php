<?php
namespace src\factories;

use src\models\Model;
use src\models\ZnamkaModel;

class ZnamkaModelFactory extends ModelFactory{
    /**
     * @param array<string, mixed> $array
     * @return Model
     */
    public static function build(array $array = []): Model{
        return parent::make(new ZnamkaModel(), $array);
    }
    
}