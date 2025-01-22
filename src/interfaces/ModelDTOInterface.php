<?php

namespace src\interfaces;

use src\models\Model;

interface ModelDTOInterface {
    public function transform(Model $model):string;
    
}