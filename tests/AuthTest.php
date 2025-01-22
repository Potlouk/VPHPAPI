<?php 
namespace tests;
use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase {

    /** @test */
    public function testUserRegister(): void{

        $body = [
            "heslo" => "heslo",
            "jmeno" => "jmeno",
            "Ucitele_Id"=> 1,
            //"Studenti_Id" => 11,
        ];

         $response = SendRequestAction::send('POST', 'registrace', $body);

         //$this->assertCookie('twoFactor');
         $this->assertEquals(200, $response['statusCode']);
      
        //$this->assertTrue(true);
    
    }


}