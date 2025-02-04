<?php
namespace src\services;

use src\factories\PredmetModelFactory;
use src\models\Model;
use src\models\PredmetModel;
use src\services\CollectionService;

class PredmetService extends CollectionService{
    
    protected Model $model;
    protected mixed $factory;

    public function __construct(){
        $this->model = new PredmetModel;
        $this->factory = PredmetModelFactory::class;
    }

}