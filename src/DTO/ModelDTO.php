<?php
namespace src\DTO;

use src\interfaces\ModelDTOInterface;
use src\models\Model;

class ModelDTO implements ModelDTOInterface{
    /**
     * @var array<int|string> List of passable attribute names
     */
    protected array $passable = []; 

    public function transform(Model $model): string | false {
        $this->setParameters($model);
        return json_encode($this->filterModel($model));
    }

    private function setParameters(Model $model): void{
        $this->passable = array_merge(array_keys($model->assignables), array_keys($model->relations), $this->passable);
        foreach ($model->relations as $rName => $models) {
            $reType   = key($models);
            $rClasses = $models[$reType];

                foreach ($rClasses as $rModel){
                    $tmp = new $rModel();
                    $this->passable = array_merge($this->passable, array_keys($tmp->assignables));
                }
        }
        $this->passable = array_unique($this->passable);
    }

    /**
     * @return array<string, mixed>
     */
    private function filterModel(Model $model): array{
        $temp = [];
        foreach(array_keys(get_object_vars($model)) as $attribute)
            if (in_array($attribute, $this->passable))
            $temp[$attribute] = $model->{$attribute};


        foreach (array_keys($model->relations) as $rName)
            foreach ($temp[$rName] as &$attribute)
            $attribute = array_intersect_key($attribute,array_flip($this->passable));
        
        return $temp;
    }
}