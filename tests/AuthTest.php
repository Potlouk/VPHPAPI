<?php 
namespace tests;
use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase {

    /** @test */
    public function testUserRegister(): void {

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

    /**
     * @depends testUserRegister
     *  @test
     */
    public function testUserLogin(): void {
        $body = [
            "heslo" => "heslo",
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