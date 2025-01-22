<?php
namespace src;

final class Path{
    public function __construct(
        public string $url,
        public string $controller,
        public string $callback,
        public array $urlData,
        public array $middleware = [],
    ){}
}