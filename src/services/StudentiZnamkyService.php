<?php
namespace src\services;

use src\factories\ModelFactory;
use src\factories\StudentiZnamkyFactory;
use src\factories\StudentModelFactory;
use src\factories\ZnamkaModelFactory;
use src\models\Model;
use src\models\StudentiZnamky;
use src\services\CollectionService;
use src\models\StudentModel;
use src\models\ZnamkaModel;

class StudentiZnamkyService extends CollectionService{
    
    protected Model $model;
    protected mixed $factory;

    public function __construct(){
        $this->model = new StudentiZnamky;
        $this->factory = StudentiZnamkyFactory::class;
    }


}