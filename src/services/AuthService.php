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
   
    /**
    * @param array<string, mixed> $data
    * @return array<string, mixed>
    */
    public function register(array $data): array {
        $data["heslo"] = self::hash($data["heslo"]);
        
        if (array_key_exists('Studenti_Id',$data) && array_key_exists('Ucitele_Id',$data))
        ApiException::throw(ErrorTypes::REQUEST_REQUIREMENTS_NOT_MET);

        $user = UzivatelFactory::build($data);
        $userId = $user->create();

        $uToken = TokenFactory::build([
            "Uzivatele_Id" => $userId,
            "token" => self::createToken(),
        ]);

        $uToken->create();

        return [ 'token' => $uToken->token  , 'user_id' => $userId ];

    }

    /**
    * @param array<string, mixed> $data
    * @return array<string, mixed>
    */
    public function login(array $data): array {
        $user = new Uzivatel();
        $user = $user->where(["jmeno", $data['jmeno']]);
    
        if(empty($user))
        ApiException::throw(ErrorTypes::UNKNOWN_USER);

        $uToken = new UzivateleTokenModel();
        $uToken = $uToken->find($user["id"]);

        if (!self::isMatchingPassword($data['heslo'], $user["heslo"]))
        ApiException::throw(ErrorTypes::USER_WRONG_PASSWORD);

        return [ 'token'=> $uToken['token'] , 'user_id' => $user["id"] ];
    }
}