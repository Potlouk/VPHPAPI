<?php
namespace src\factories;

use src\models\Model;
use src\models\PredmetModel;
use src\models\TridaModel;

final class PredmetModelFactory extends ModelFactory{
    /**
     * @param array<string, mixed> $array
     * @return Model
     */
    public static function build(array $array = []): Model{
        return parent::make(new PredmetModel(), $array);
    }

}