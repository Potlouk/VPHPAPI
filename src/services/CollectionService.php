<?php
namespace src\services;

use src\Enums\ErrorTypes;
use src\interfaces\CollectionInterface;
use src\models\Model;
use src\traits\ApiException;

class CollectionService implements CollectionInterface{

    protected Model $model;
    protected mixed $factory;

    public function get(array $data): Model{
        $keyName = $this->model->primaryKey;

        $model = $this->model->where(
            [ $keyName, $data["{$keyName}"] ]
        );

        if (!$model)
        ApiException::throw(ErrorTypes::MODEL_NOT_FOUND,[ get_class($this->model) ], 404);

        $model = $this->factory::build($model);
        $model->getRelations();
        
        return $model;
    }
    
    /**
     * @param array<string,mixed> $data
     * @return array<string,mixed>
     */
    public function create(array $data): array{
        $model = $this->factory::build($data);
        return [ "id" => $model->create() ];  
    }

    /**
     * @param array<string,mixed> $data
     */
    public function patch(array $data): void{
        $currentData = $this->model->find( 
            $data["id"]
        );

        if (empty($currentData))
        ApiException::throw(ErrorTypes::MODEL_NOT_FOUND,[ 
            basename(str_replace('\\', '/', get_class($this->model)))
         ], 404);

        foreach($data as $key => $value)
        $currentData[$key] = $value;

        $model = $this->factory::build($currentData);
        $model->patch();
    }

    /**
     * @param array<string,mixed> $data
     */
    public function delete(array $data): void{
        $currentData =  $this->model->find(
            $data["id"]
        );

        if (empty($currentData))
        ApiException::throw(ErrorTypes::MODEL_NOT_FOUND,[ get_class($this->model) ], 404);

        $model = $this->factory::build($currentData);
        $model->delete();  
    }

    /**
     * @param array<string,mixed> $data
     * @return array<string,mixed>
     */
    public function paginate(array $data): array{
        $result = (array) $this->model->paginate(
            $data['current'], 
            $data['limit']
        );

        return $result;
    }
   
}