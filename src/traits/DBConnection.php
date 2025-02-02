<?php
namespace src\traits;

use Exception;
use PDO;
use PDOException;

trait DBConnection {
    private static ?self $instance = null;
    private PDO $connection;

    private function init(): void {
      
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

    private function logError(string $message): void {
        $logFile = __DIR__ . '/../../logs.txt';
        file_put_contents($logFile, date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL, FILE_APPEND);
    }

    private function getConnection(): PDO {
        if (self::$instance === null) {
            self::$instance = new self();
            self::$instance->init();
        }
        return self::$instance->connection;
    }

     /**
     * Executes query
     * @param  $db PDO instance.
     * @return mixed
     */
    private function executeQuery(mixed $db = null): mixed {
        if(is_null($db))
        $db = $this->getConnection()->prepare($this->query);
        
        try { $db->execute(); } catch(Exception $e){
            ApiException::logError($e);
        }
        
        return $db;
    }

     /**
     * Binds values to placeholders in query query and executes.
     * The indexes of array with values must correspond to order of query;
     * @param array<string, mixed> $values Data for insertion with keys corresponding with Model's assignables.
     * @param array<string, string> $types Model's assignables.
     */
    private function bindAndExecute(array $values, array $types): mixed {
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