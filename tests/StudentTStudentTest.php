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
        $this->assertJsonStructure(
            json_decode($response['body'], true),
            $expectedStructure
        );
    }

    /**
     * @depends getTest
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


    private function assertJsonStructure(array $expectedStructure, array $actualArray)
    {
        foreach ($expectedStructure as $key => $value) {
            // Check if the key exists
            $this->assertArrayHasKey($key, $actualArray, "Missing key: $key");
    
            // If the value is an array, check recursively for nested structure
            if (is_array($value)) {
                $this->assertJsonStructure($value, $actualArray[$key]);
            }
        }
    }
}