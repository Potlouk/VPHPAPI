<?php 
namespace tests;

trait HelperTrait {
    private static string $endpoint;
    
    private function getEndpointUrl(?int $id = null): string {
        return $id ? self::$endpoint."/{$id}": self::$endpoint;
    }
}
