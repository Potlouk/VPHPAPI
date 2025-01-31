<?php
namespace src\models;

use src\traits\DBConnection;

use PDO;
use src\interfaces\ModelInterface;
use src\traits\Serialisation;

#[\AllowDynamicProperties]
class Model implements ModelInterface{
    use DBConnection, Serialisation;

    public string $primaryKey = '';
    protected string $table = '';
    protected string $query = "";
    public int $id;
    public $assignables = [];
    public $relations = [];

    public function getRelations(): void{
        
        foreach ($this->relations as $rName => $relation) {
            $reType   = key($relation);
            $rClasses = $relation[$reType];
            $rIndex   = $rClasses[sizeof($rClasses)-1];

            if($reType == 'one')
            $this->{$rName} = $this->{$reType}($rIndex ,$rName);
            else
            $this->{$rName} = $this->{$reType}($rIndex ,$rClasses);
        }
    }

    private function many(string $rObject, mixed $rClasses): array{
        $rObject = new $rObject(); 
        $rTable  = "{$this->table}_{$rObject->table}";

        $this->query = "SELECT * FROM {$rTable} ";

        foreach($rClasses as $rClass){
            $tmp = new $rClass();
            $this->query .= "JOIN {$tmp->table} ON {$rTable}.{$tmp->table}_{$tmp->primaryKey} = {$tmp->table}.{$tmp->primaryKey} ";
        }

        $this->query .= "WHERE {$this->table}_{$this->primaryKey} = {$this->id}";
            
        $result = $this->executeQuery()->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    private function one(string $rObject, string $rValue) : array{
        $rObject = new $rObject();

        $this->query = "SELECT * FROM {$rObject->table}
        WHERE {$rObject->primaryKey} = {$this->{$rValue}}";

        return $this->executeQuery()->fetchAll(PDO::FETCH_ASSOC);
    }

   public function where(array $array): array | bool {
        $this->query = "SELECT * FROM {$this->table} WHERE {$array[0]} = ?";
        return $this->bindAndExecute([$array[0] => $array[1]], [$array[0] => 'string'])->fetch(PDO::FETCH_ASSOC);
    }

    public function find(int $id): array | bool {
        $this->query = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return $this->bindAndExecute(["{$this->primaryKey}" => $id],[ "{$this->primaryKey}" => 'integer'])->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * Fetches result of a sql command.
     * @return array result.
     */
    public function get(): array{
        return $this->executeQuery()->fetchAll(PDO::FETCH_ASSOC);
    }

     /**
     * Saves model into database and sets its id.
     * @return int Assigned Model's id.
     */
    public function create(): int{
        $mANames      =  $this->toKeyNameString($this->assignables);
        $placeholders =  $this->toStringPlaceHolder($this->assignables,'?');
        $this->query  = "INSERT INTO {$this->table} ({$mANames}) VALUES ({$placeholders})";
    
        $this->bindAndExecute(get_object_vars($this), $this->assignables);
        return $this->getId();
    }
    
    public function patch(): void{
        $placeholders =  $this->toArrayPlaceHolder($this->assignables,'?');
        $this->query  = "UPDATE {$this->table} SET {$placeholders} WHERE {$this->primaryKey} = {$this->id}";

        $this->bindAndExecute(get_object_vars($this), $this->assignables);
    }

    public function delete(): void{
        $this->query = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $this->bindAndExecute(["{$this->primaryKey}" => $this->id],[ "{$this->primaryKey}" => 'integer']);
    }


     /**
     * Paginate query results.
     * @param int $current page.
     * @param int $limit of items on page.
     * @return int Assigned Model's id.
     */
    public function paginate(int $current, int $limit): array{
        $totalRows = $this->getTotalResults();

        $currentPage = ($current - 1) * $limit;

        $this->query = "SELECT * FROM {$this->table} ORDER BY {$this->primaryKey} DESC LIMIT ?,?";
        $result = $this->bindAndExecute(["current" => $currentPage , "limit" => $limit ],["current" => 'integer', "limit" => 'integer']);
     
        
        return [
            "data"        => $result->fetchAll(PDO::FETCH_ASSOC),
            "currentPage" => $current,
            "lastPage"    => intval(ceil($totalRows/$limit)),
        ];
    }

     /**
     * Returns last inserted id of model.
     * @return int Assigned Model's id.
     */
    private function getId(): int{
        return intval($this->getConnection()->lastInsertId());
    }

    private function getTotalResults(): int{
        $this->query = "SELECT count(*) FROM {$this->table}";
        return ($this->executeQuery()->fetch(PDO::FETCH_COLUMN));
    }
}