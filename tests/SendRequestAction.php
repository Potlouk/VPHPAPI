<?php
namespace tests;
use Dotenv\Dotenv;
use src\Config;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->safeLoad();

class SendRequestAction {

    static function send(string $method, string $endpoint ,array $body = []): array {
        $sPort = Config::getEnv('SERVER_PORT');
        $url = "http://localhost:{$sPort}/{$endpoint}";
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($method !== 'GET') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        }

        $body = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return [
            'statusCode' => $statusCode,
            'body'       => json_decode($body, true)
        ];

    }
} 