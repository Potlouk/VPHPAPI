<?php
namespace src\traits;

use src\Config;

trait Auth {

    private static function createToken(int $length = 32): string {
       return bin2hex(random_bytes($length / 2));
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

    private static function isAdmin($auth) {
        return is_null($auth->Ucitele_Id) && is_null($auth->Studenti_Id);
    }

}