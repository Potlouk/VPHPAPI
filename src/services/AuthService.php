<?php
namespace src\services;

use src\Enums\ErrorTypes;
use src\factories\TokenFactory;
use src\factories\UzivatelFactory;
use src\models\Uzivatel;
use src\models\UzivateleTokenModel;
use src\traits\ApiException;
use src\traits\Auth;

final class AuthService {
    use Auth; 
   
    public function register(array $data): array {
        $data["heslo"] = self::hash($data["heslo"]);
        
        $user = UzivatelFactory::build($data);
        $userId = $user->create();

        $uToken = TokenFactory::build([
            "Uzivatele_Id" => $userId,
            "token" => self::createToken(),
        ]);

        $uToken->create();

        return [ 'token' => $uToken->token , 'user_id' => $userId ];
    }

    public function login(array $data): array {
        $user = new Uzivatel();
        $user = $user->where(["jmeno", $data['jmeno']]);
    
        if(!$user)
        ApiException::throw(ErrorTypes::UNKNOWN_USER);

        $uToken = new UzivateleTokenModel();
        $uToken = $uToken->find($user["id"]);

        if (!self::isMatchingPassword($data['heslo'], $user["heslo"]))
        ApiException::throw(ErrorTypes::USER_WRONG_PASSWORD);

        return [ 'token'=> $uToken['token'] , 'user_id' => $user["id"] ];
    }
}