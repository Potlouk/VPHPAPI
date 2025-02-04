<?php
namespace src\services;

use src\factories\StudentModelFactory;
use src\models\Model;
use src\services\CollectionService;
use src\models\StudentModel;
use src\models\UcitelModel;

class StudentService extends CollectionService{
    
    protected Model $model;
    protected mixed $factory;

    public function __construct(){
        $this->model = new StudentModel;
        $this->factory = StudentModelFactory::class;
    }
    
    /**
     * ALL query results
     * @param int $id teacher
     * @return array<string, mixed>
     */
    public function allFromTeacherClass(int $id): array {
        $teacher = new UcitelModel();
        $teacher = $teacher->find($id);

        $result = $this->model->all(['trida', $teacher['trida_Id']]);
        return $result;
      }
}