<?php
namespace tests;
use Dotenv\Dotenv;
use src\Config;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->safeLoad();

class SendRequestAction {

    private static array $cookies = [];

    public static function setCookies(array $cookies): void {
        self::$cookies = $cookies;
    }

    static function send(string $method, string $endpoint, array $body = []): array {
        $sPort = Config::getEnv('SERVER_PORT');
        $url = "http://localhost:{$sPort}/{$endpoint}";
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        if (!empty(self::$cookies)) {
            $cookieString = '';
            foreach (self::$cookies as $name => $value) 
            $cookieString .= "{$name}={$value}; ";

            $cookieString = rtrim($cookieString, '; ');
            curl_setopt($ch, CURLOPT_COOKIE, $cookieString);
        }

        if ($method !== 'GET') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        }

        $response = curl_exec($ch);

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        $header = substr($response, 0, $headerSize);
        $body   = substr($response, $headerSize);

        curl_close($ch);

        preg_match_all('/^Set-Cookie:\s*([^=\s]+)=([^\r\n]*)/mi', $header, $matches);
     
        foreach ($matches[1] as $index => $key) {
            $cookies[$key] = trim($matches[2][$index]);
        }

        if (!empty($body) && $body != null) {
            $decodedBody = json_decode($body, true);
            $body = isset($decodedBody['data']) ? $decodedBody['data'] : $decodedBody;
        }

        return [
            'statusCode' => $statusCode,
            'body'       => $body ?? [],
            'cookies'    => isset($cookies) ? $cookies : []
        ];
    }

    
} 