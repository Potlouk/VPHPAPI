<?php 
namespace tests;
use PHPUnit\Framework\TestCase;

class AdminTest extends TestCase {
    use HelperTrait;
    private static int $studentId;
    private static int $ucitelId;
     /** @test */
    public function createStudentTest(): void {
        self::$endpoint = 'student';
        $body = [
            "jmeno"     => "testCreate",
            "prijmeni"  => "1111-11-11",
            "trida" => 1,
        ];

        $response = SendRequestAction::send(
            'POST', 
            $this->getEndpointUrl(), 
            $body
        );

        $this->assertEquals(200, $response['statusCode']);
        $this->assertArrayHasKey('id', $response['body']);

        self::$studentId = $response['body']['id'];
    }

    /**
     * @depends createStudentTest
     * @test
     */
    public function deleteStudentTest(): void {
        $response = SendRequestAction::send(
            'DELETE',
            $this->getEndpointUrl(self::$studentId)
        );

        $this->assertEquals(200, $response['statusCode']);
        
        $response = SendRequestAction::send(
            'GET',
            $this->getEndpointUrl(self::$studentId)
        );

        $this->assertEquals(404, $response['statusCode']);

    }
    
   /** @test */
    public function createUcitelTest(): void {
        self::$endpoint = 'ucitel';
        $body = [
            "jmeno"     => "testCreate",
            "trida_Id"  => 1,
        ];

        $response = SendRequestAction::send(
            'POST',
            $this->getEndpointUrl(),
            $body
        );

        $this->assertEquals(200, $response['statusCode']);
        $this->assertArrayHasKey('id', $response['body']);

        self::$ucitelId = $response['body']['id'];
    }
    /**
     * @depends createUcitelTest
     * @test
     */
    public function deleteUcitelTest(): void {
        $response = SendRequestAction::send(
            'DELETE',
            $this->getEndpointUrl(self::$ucitelId)
        );

        $this->assertEquals(200, $response['statusCode']);

        $response = SendRequestAction::send(
            'GET',
            $this->getEndpointUrl(self::$ucitelId)
        );

        $this->assertEquals(404, $response['statusCode']);

    }
}