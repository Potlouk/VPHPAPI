<?php
namespace src\services;

use src\factories\TridaModelFactory;
use src\models\Model;
use src\models\TridaModel;
use src\services\CollectionService;

class TridaService extends CollectionService{
    
    protected Model $model;
    protected mixed $factory;

    public function __construct(){
        $this->model = new TridaModel;
        $this->factory = TridaModelFactory::class;
    }

}