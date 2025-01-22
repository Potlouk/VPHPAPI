<?php
namespace src\services;

use src\factories\StudentModelFactory;
use src\models\Model;
use src\services\CollectionService;
use src\models\StudentModel;

class StudentService extends CollectionService{
    
    protected Model $model;
    protected $factory;

    public function __construct(){
        $this->model = new StudentModel;
        $this->factory = StudentModelFactory::class;
    }

}