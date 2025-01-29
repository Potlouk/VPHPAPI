<?php 
namespace tests;
use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase {

    
    /** @test */
    public function testUserRegister(): void {

       $body = [
            "heslo" => "heslo",
            "jmeno" => "jmeno",
            "Ucitele_Id"=> 1,
            //"Studenti_Id" => 11,
        ];

        $response = SendRequestAction::send('POST', 'registrace', $body);

        $this->assertEquals(200, $response['statusCode']);
        $this->assertArrayHasKey('token',   $response['cookies']);
        $this->assertArrayHasKey('user_id', $response['cookies']);

     //   var_export($response);
        SendRequestAction::setCookies([
            'token' => $response['cookies']['token'] , 'user_id' => $response['cookies']['user_id']
        ]);

    }

    /**
     * @depends testUserRegister
     *  @test
     */
    public function testUserLogin(): void {
        $body = [
            "heslo" => "heslo",
            "jmeno" => "jmeno",
        ];

        $response = SendRequestAction::send('POST', 'prihlaseni', $body);

        $this->assertEquals(200, $response['statusCode']);
        $this->assertArrayHasKey('token',   $response['cookies']);
        $this->assertArrayHasKey('user_id', $response['cookies']);
    }
}