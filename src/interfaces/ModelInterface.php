<?php
namespace src\interfaces;
interface ModelInterface{
   public function where(array $arg): array | bool;
   public function get(): array;
   public function create(): int;
   public function patch(): void;
   public function find(int $id): array | bool;
  // public function __construct();
  // public function exists(): self;
}