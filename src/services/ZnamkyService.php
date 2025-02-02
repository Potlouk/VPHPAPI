<?php
namespace src\services;

use src\Enums\ErrorTypes;
use src\factories\ModelFactory;
use src\factories\StudentiZnamkyFactory;
use src\factories\StudentModelFactory;
use src\factories\ZnamkaModelFactory;
use src\models\Model;
use src\models\StudentiZnamky;
use src\services\CollectionService;
use src\models\StudentModel;
use src\models\ZnamkaModel;
use src\traits\ApiException;

class ZnamkyService extends CollectionService{
    
    protected Model $model;
    protected mixed $factory;

    public function __construct(){
        $this->model = new ZnamkaModel;
        $this->factory = ZnamkaModelFactory::class;
    }

    public function create(array $data): array {
      
        $znamkaId = parent::create($data);
        $znamkaData = $this->model->find($znamkaId["id"]);
        
        if (empty($znamkaData))
        ApiException::throw(ErrorTypes::MODEL_NOT_FOUND);

        $znamka = $this->factory::build($znamkaData);

        $nZnamka = StudentiZnamkyFactory::build(
            array_merge(
                ['Znamky_Id' => $znamka->id ],
                $data
            ));
            
        $nZnamka->create();    
        return [ "id" => $znamka->id ];
    }

    

}