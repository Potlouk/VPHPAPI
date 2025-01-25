<?php
namespace src\traits;

use src\Config;

trait Auth {

    private static function createToken(int $length = 32): string {
        //bett
        return substr(str_shuffle(str_repeat(Config::getEnv('APP_CHAR_TOKEN_POOL'), $length)), 1, $length);
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


}