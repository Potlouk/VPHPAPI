<?php
namespace src\services;

use src\factories\StudentiZnamkyFactory;
use src\factories\StudentModelFactory;
use src\factories\ZnamkaModelFactory;
use src\models\Model;
use src\models\StudentiZnamky;
use src\services\CollectionService;
use src\models\StudentModel;
use src\models\ZnamkaModel;

class ZnamkyService extends CollectionService{
    
    protected Model $model;
    protected $factory;

    public function __construct(){
        $this->model = new ZnamkaModel;
        $this->factory = ZnamkaModelFactory::class;
    }

    public function create(array $data): array {
      
        $znamkaId = parent::create($data);
        $znamka = $this->factory::build($this->model->find($znamkaId["id"]));

        $nZnamka = StudentiZnamkyFactory::build(
            array_merge(
                ['Znamky_Id' => $znamka->id ],
                $data
            ));
            
        $nZnamka->create();    
        return [ "id" => $znamka->id ];
    }

    

}