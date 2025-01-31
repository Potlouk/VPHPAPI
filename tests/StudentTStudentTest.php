<?php 
namespace tests;
use PHPUnit\Framework\TestCase;

class StudentTStudentTest extends TestCase {
    use HelperTrait;
    private $studentId = 9;
    
    /** @test */
    public function getTest(): void {
        self::$endpoint = 'student';
        
        $response = SendRequestAction::send( 
            'GET', 
            $this->getEndpointUrl($this->studentId)
        );

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
        $body = [ "jmeno" => "test" ];

        $response = SendRequestAction::send(
            'PATCH', 
            $this->getEndpointUrl($this->studentId),
            $body
        );

        $this->assertEquals(200, $response['statusCode']);
        
        $response = SendRequestAction::send(
            'GET',
            $this->getEndpointUrl($this->studentId)
        );

        $this->assertEquals($response['body']['jmeno'], $body['jmeno']);
    }

}