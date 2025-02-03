<?php
namespace src\services;

use src\factories\StudentiZnamkyFactory;
use src\models\Model;
use src\models\StudentiZnamky;
use src\services\CollectionService;

class StudentiZnamkyService extends CollectionService{
    
    protected Model $model;
    protected mixed $factory;

    public function __construct(){
        $this->model = new StudentiZnamky;
        $this->factory = new StudentiZnamkyFactory;
    }

}