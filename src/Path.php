<?php
namespace src;

final class Path{
    /**
     * @param string $url
     * @param string $controller
     * @param string $callback
     * @param array<string, mixed> $urlData
     * @param array<int, string> $middleware
     */
    public function __construct(
        public string $url,
        public string $controller,
        public string $callback,
        public array $urlData,
        public array $middleware = [],
    ){}
}