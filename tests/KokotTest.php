<?php 
namespace tests;
use PHPUnit\Framework\TestCase;

class KokotTest extends TestCase {

    /** @test */
    public function testGetEndpoint(): void{

         $response = SendRequestAction::send("GET",'student/11');
         $this->assertEquals(200, $response['statusCode']);
      
        //$this->assertTrue(true);
    
    }


}