<?php
namespace src\traits;

use src\Config;
use src\models\Model;

trait Auth {

    private static function createToken(int $length = 32): string {
       $bytesNeeded = max(intdiv($length, 2), 1);
       return bin2hex(random_bytes($bytesNeeded));
    }
    
    private static function isMatchingToken(string $tokenA, string $tokenB): bool {
        return $tokenA == $tokenB;
    }

    private static function isMatchingPassword(string $password, string $hash): bool {
        return password_verify($password, $hash);
    }

    private static function hash(string $password): string {
        return password_hash($password, PASSWORD_BCRYPT, ["cost" => Config::getEnv('APP_HASH_COST')]);
    }

    private static function isAdmin(Model $auth) : bool {
        if (!property_exists($auth,'Ucitele_Id') || !property_exists($auth,'Studenti_Id'))
        return false;
    
        return is_null($auth->Ucitele_Id) && is_null($auth->Studenti_Id);
    }

}