<?php
namespace src\factories;

use src\models\Model;
use src\models\UzivateleTokenModel;

final class TokenFactory extends ModelFactory{
    /**
     * @param array<string, mixed> $array
     * @return Model
     */
    public static function build(array $array = []): Model{
        return parent::make(new UzivateleTokenModel(), $array);
    }

}