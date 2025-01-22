<?php
namespace src\DTO;

use src\interfaces\ModelDTOInterface;
use src\models\Model;

class ModelDTO implements ModelDTOInterface{
    Protected $passable = []; 

    public function transform(Model $student): string{
        $this->setParameters($student);
        return json_encode($this->filterModel($student));
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

    private function filterModel(Model $student): array{
        $temp = [];
        foreach(array_keys(get_object_vars($student)) as $attribute)
            if (in_array($attribute, $this->passable))
            $temp[$attribute] = $student->{$attribute};


        foreach (array_keys($student->relations) as $rName)
            foreach ($temp[$rName] as &$attribute)
            $attribute = array_intersect_key($attribute,array_flip($this->passable));
        
        return $temp;
    }
}