<?php
namespace src\interfaces;

use src\models\Model;

interface CollectionInterface{
    /**
    * @param array<string, mixed> $data
    */
    public function delete(array $data): void;

    /**
    * @param array<string, mixed> $data
    */
    public function get(array $data): Model;
    
    /**
    * @param array<string, mixed> $data
    * @return array<string, mixed> $data
    */
    public function paginate(array $data): array;
    
    /**
    * @param array<string, mixed> $data
    * @return array<string, mixed> $data
    */
    public function create(array $data): array;
    
    /**
    * @param array<string, mixed> $data
    */
    public function patch(array $data): void;
    
}