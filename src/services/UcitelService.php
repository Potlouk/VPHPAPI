<?php
namespace src\services;

use src\factories\UcitelModelFactory;
use src\models\Model;
use src\services\CollectionService;
use src\models\UcitelModel;

class UcitelService extends CollectionService{
    
    protected Model $model;
    protected $factory;

    public function __construct(){
        $this->model = new UcitelModel;
        $this->factory = UcitelModelFactory::class;
    }

}