<?php 
namespace tests;
use PHPUnit\Framework\TestCase;

class StudentTStudentTest extends TestCase {
        private $studentId = 9;
    
    /** @test */
    public function getTest(): void {
  
        $response = SendRequestAction::send('GET', "student/{$this->studentId}");

        $expectedStructure = [
            "jmeno"     => "",
            "prijmeni"  => "",
            "trida"     => [],
            "predmety"  => [],
            "znamky"    => [],
        ];

        $this->assertEquals(200, $response['statusCode']);

        foreach ($expectedStructure as $key => $value) {
            $this->assertArrayHasKey($key, $response['body']);
        }
    }

    /**
     * @depends getTest
     * @test
     */
    public function patchTest(): void {
        //jen mail ?
        $body = [
            "jmeno" => "test",
        ];

        $response = SendRequestAction::send('PATCH', "student/{$this->studentId}", $body);
        $this->assertEquals(200, $response['statusCode']);
        
        $response = SendRequestAction::send('GET', "student/{$this->studentId}");
        $this->assertEquals($response['body']['jmeno'], $body['jmeno']);
    }

}