<?php
namespace src\traits;

use Exception;
use PDO;
use PDOException;
use src\Config;
use src\Enums\ErrorTypes;

trait DBConnection {
    private static ?self $instance = null;
    private PDO $connection;

    private function init(): void {
        $name = Config::getEnv('DB_NAME');
        $port = Config::getEnv('DB_PORT');
        $host = Config::getEnv('DB_HOST');
        $username =  Config::getEnv('DB_USER');
        $password =  Config::getEnv('DB_PASSWORD');

        $dsn = "mysql:host={$host};port={$port};dbname={$name}";

     try {
            $this->connection = new PDO($dsn, $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            ApiException::logError('PDO ERROR: ' . $e->getMessage());
            ApiException::throw(ErrorTypes::INTERNAL_SERVER_ERROR);
        }
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