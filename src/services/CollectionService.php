<?php
namespace src\services;

use src\Enums\ErrorTypes;
use src\interfaces\CollectionInterface;
use src\models\Model;
use src\models\ZnamkaModel;
use src\traits\ApiException;

class CollectionService implements CollectionInterface{

    protected Model $model;
    protected $factory;

    public function get(array $data): Model{
        $keyName = $this->model->primaryKey;

        $model = $this->model->where(
            [ $keyName, $data["{$keyName}"] ]
        );

        if (!$model)
        ApiException::throw(ErrorTypes::MODEL_NOT_FOUND,[ get_class($this) ]);

        $model = $this->factory::build($model);
        $model->getRelations();
        
        return $model;
    }

    public function create(array $data): int{
        $model = $this->factory::build($data);
        return $model->create();  
    }

    public function patch(array $data): void{
        $currentData = $this->find( 
            $data["{$this->model->primaryKey}"]
        );

        if (!$currentData)
        ApiException::throw(ErrorTypes::MODEL_NOT_FOUND,[ get_class($this) ]);

        foreach($data as $key => $value)
        $currentData[$key] = $value;

        $model = $this->factory::build($currentData);
        $model->patch();
    }

    public function delete($data): void{
        $currentData =  $this->model->find(
            $data["{$this->model->primaryKey}"]
        );

        if (!$currentData)
        ApiException::throw(ErrorTypes::MODEL_NOT_FOUND,[ get_class($this) ]);

        $model = $this->factory::build($currentData);
        $model->delete();  
    }

    public function paginate(array $data): array{
        $result = (array) $this->model->paginate(
            $data['current'], 
            $data['limit']
        );

        return $result;
    }

    public function all(){}
    public function findOne(){}
    public function find(){}
   
}