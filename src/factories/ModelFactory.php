<?php
namespace src\factories;

use src\models\Model;

class ModelFactory{

    protected static function make(Model $model ,array $array = []): Model{  
        
        if(array_key_exists('id',$array)){
            $model->id = $array['id'];
            unset($array['id']);
        }

        foreach ($model->assignables as $name => $type){
            if (array_key_exists($name, $array))
            $model->{$name} = $array[$name];
            else $model->{$name} = self::setDefaultValue($type);

            settype($model->{$name},$model->assignables[$name]);
        }
        return $model;
    }

    private static function setDefaultValue(string $type): mixed{
        return match ($type) {
            'integer' => 0,
            'string' => '',
            'bool' => false,
            default => null,
        };
    }

}