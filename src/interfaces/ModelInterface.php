<?php
namespace src\interfaces;
interface ModelInterface{

    /**
    * @param array<string> $arg
    * @return array<string,mixed>
    */
   public function where(array $arg): array;
  
   public function get(): mixed;
   public function create(): int;
   public function patch(): void;
  /**
    * @return array<string>
    */
   public function find(int $id): array;
}