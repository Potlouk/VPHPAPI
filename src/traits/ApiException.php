<?php
namespace src\traits;

use Exception;
use src\Enums\ErrorTypes;
final Class ApiException extends Exception {

    public static function logError(string $message): void {
        $logFile = __DIR__ . '/../../logs.txt';
        file_put_contents($logFile, date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL, FILE_APPEND);
    }

    /**
     * @param array<mixed, mixed> $data
    */
   public static function throw(ErrorTypes $error, array $data = [], int $statusCode = 500): void {
        $description = self::getDescription($error,$data);    
        self::logError($description);
        throw new self($description, $statusCode);
    }


    /**
     * @param array<string> $data
     */
    private static function getDescription(ErrorTypes $type, array $data = [] ): string{
        $keys = array_keys($data);
        return match ($type){
                ErrorTypes::EMPTY_REQUEST                   => 'Empty request passed.',
                ErrorTypes::UNKNOWN_METHOD                  => 'Not supported method.',
                ErrorTypes::UNKNOWN_SERVER_REQUEST          => 'Unknown request.',
                ErrorTypes::UNSUPPORTED_PATH                => 'Endpoint not found.',
                ErrorTypes::WRONG_DATA_TYPE                 => "Wrong data type passed on {$keys[0]} must be {$data[$keys[0]]}.",
                ErrorTypes::INVALID_RANGE_NUMBER            => 'Invalid page number. Page number must be 1 or greater.',
                ErrorTypes::REQUEST_REQUIREMENTS_NOT_MET    => "Request's atributes doesn't meet required data.",
                ErrorTypes::USER_ALREADY_REGISTERED         => 'User with these credentials is already registered.',
                ErrorTypes::USER_WRONG_PASSWORD             => "User's password doesn't match.",
                ErrorTypes::USER_WRONG_TOKEN                => "User's token passed.",
                ErrorTypes::AUTH_COOKIE_NOT_PASSED          => "Auth cookie not passed.",
                ErrorTypes::AUTH_COOKIE_NOT_SATISFIED       => "Auth cookie not satisfied.",
                ErrorTypes::UNKNOWN_USER                    => "Unknown user passed.",
                ErrorTypes::MODEL_NOT_FOUND                 => "{$data[0]} not found.",
                ErrorTypes::UNAUTHORIZED                    => "Unauthorized action.",
                ErrorTypes::INTERNAL_SERVER_ERROR           => 'Internal server error.'
            };
    }
}