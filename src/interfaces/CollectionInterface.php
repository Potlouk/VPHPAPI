<?php
namespace src\interfaces;

use src\models\Model;

interface CollectionInterface{
    public function all();
    public function find();
    public function delete(array $id);
    public function get(array $request): Model;
    public function paginate(array $request);
}