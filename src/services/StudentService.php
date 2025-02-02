<?php
namespace src\services;

use src\factories\ModelFactory;
use src\factories\StudentModelFactory;
use src\models\Model;
use src\services\CollectionService;
use src\models\StudentModel;

class StudentService extends CollectionService{
    
    protected Model $model;
    protected mixed $factory;

    public function __construct(){
        $this->model = new StudentModel;
        $this->factory = StudentModelFactory::class;
    }

}