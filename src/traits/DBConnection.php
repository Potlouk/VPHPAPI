<?php
namespace src\traits;

use Exception;
use PDO;
use PDOException;
use PDORow;
use PDOStatement;

trait DBConnection {
    private static $instance = null;
    private $connection;

    private function init() {
      
        $dsn = 'mysql:host=db;port=3306;dbname=PHPAPI';
        $username = 'root';
        $password = '';

     try {
            $this->connection = new PDO($dsn, $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->logError('Connection faileds: ' . $e->getMessage());
        }
    }

    private function logError(string $message) {
        $logFile = __DIR__ . '/../../logs.txt';
        file_put_contents($logFile, date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL, FILE_APPEND);
    }

    private function getConnection() {
        if (self::$instance === null) {
            self::$instance = new self();
            self::$instance->init();
        }
        return self::$instance->connection;
    }

     /**
     * Binds values to placeholders in query query and executes.
     * The indexes of array with values must correspond to order of query;
     * @param  optional PDOinstance $db PDO instance.
     * @return PDOinstance 
     */
    private function executeQuery(mixed $db = null): mixed{
      if($db === null) $db = $this->getConnection()->prepare($this->query);
        try {
            print_r($this->query);
            $db->execute();
        } catch(Exception $e){
            //create kill switch on errors lmao
          echo $e;
            return $e;
        }
        
        return $db;
    }

     /**
     * Binds values to placeholders in query query and executes.
     * The indexes of array with values must correspond to order of query;
     * @param  array $values Data for insertion with keys corresponding with Model's assignables.
     * @param array $types Model's assignables.
     */
    private function bindAndExecute(array $values, array $types) {
        $index = 1;
        $db = $this->getConnection()->prepare($this->query);
       
        foreach ($types as $key => $type)
            $db->bindParam($index++,$values[$key],$this->convertPDOType(gettype($values[$key])));
        
    
        return $this->executeQuery($db);  
    }

    private function convertPDOType(string $type): int {
        return match ($type) {
            'string' => PDO::PARAM_STR,
            'integer' => PDO::PARAM_INT,
            'bool' => PDO::PARAM_BOOL,
            default => PDO::PARAM_NULL,
        };
    }

    private function __clone() {}
    public function __wakeup() {}
}