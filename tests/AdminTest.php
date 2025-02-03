<?php 
namespace tests;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Depends;
use tests\helpers\HelperTrait;
use tests\helpers\SendRequestAction;

class AdminTest extends TestCase {
    use HelperTrait;
    private static int $studentId;
    private static int $ucitelId;
    
    #[Test]
    public function studentAccountCanBeCreated(): void {
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

    #[Test]
    #[Depends('studentAccountCanBeCreated')]
    public function studentAccountCanBeDeleted(): void {
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
    
    #[Test]
    public function teacherAccountCanBeCreated(): void {
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

    #[Test]
    #[Depends('teacherAccountCanBeCreated')]
    public function teacherAccountCanBeDeleted(): void {
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