<?php 
namespace tests;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Depends;
use tests\helpers\SendRequestAction;

class AuthTest extends TestCase {

    #[Test]
    public function userCanBeRegistered(): void {

       $body = [
            "heslo" => "heslo",
            "jmeno" => "student",
            "Ucitele_Id"=> 1,
            //"Studenti_Id" => x,
        ];

        $response = SendRequestAction::send(
            'POST',
            'registrace', 
            $body
        );

        $this->assertEquals(200, $response['statusCode']);
        $this->assertArrayHasKey('token',   $response['cookies']);
        $this->assertArrayHasKey('user_id', $response['cookies']);
    }

    #[Test]
    #[Depends('userCanBeRegistered')]
    public function userCanLogin(): void {
        $body = [
            "heslo" => "root",
            "jmeno" => "admin",
        ];

        $response = SendRequestAction::send(
            'POST',
            'prihlaseni',
            $body
        );

        $this->assertEquals(200, $response['statusCode']);
        $this->assertArrayHasKey('token',   $response['cookies']);
        $this->assertArrayHasKey('user_id', $response['cookies']);

        SendRequestAction::setCookies([
            'token' => $response['cookies']['token'] , 
            'user_id' => $response['cookies']['user_id'],
        ]);
        
    }
}