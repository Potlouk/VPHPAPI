<?php
namespace src\actions;
use src\Config;

final class MiddlewareConvertAction {

    public static function convert(string $name) : string | bool {
        if (array_key_exists("{$name}", Config::$middlewareLookup))
        return Config::$middlewareLookup[$name];

        return false;
    }

}