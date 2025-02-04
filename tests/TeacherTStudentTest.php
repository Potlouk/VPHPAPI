<?php 
namespace tests;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Depends;
use tests\helpers\HelperTrait;
use tests\helpers\SendRequestAction;

class TeacherTStudentTest extends TestCase {
    use HelperTrait;
    private static int $znamkaId;

    #[Test]
    public function gradeCanBeCreated(): void {
        self::$endpoint = 'znamka';
        $body = [
            "poznamka"    => "testCreate",
            "zapsano"     => "1111-11-11",
            "znamka"      => 1,
            "Studenti_Id" => 1,
            "Predmety_Id" => 1
        ];

        $response = SendRequestAction::send(
            'POST',
            $this->getEndpointUrl(),
            $body
        );
        $this->assertEquals(200, $response['statusCode']);
        $this->assertArrayHasKey('id', $response['body']);

        self::$znamkaId = $response['body']['id'];
    }

    #[Test]
    #[Depends('gradeCanBeCreated')]
    public function gradeCanBeEdited(): void {
        $body = [ "znamka" => 5 ];
        $response = SendRequestAction::send(
            'PATCH', 
            $this->getEndpointUrl(self::$znamkaId),
            $body
        );

        $this->assertEquals(200, $response['statusCode']);
        
        $response = SendRequestAction::send(
            'GET', 
            $this->getEndpointUrl(self::$znamkaId)
        );

        $this->assertEquals(200, $response['statusCode']);
        $this->assertNotFalse($response);
        $this->assertEquals($response['body']['znamka'], 5);
    }

    #[Test]
    #[Depends('gradeCanBeCreated')]
    public function gradeCanBeDeleted(): void {
        $response = SendRequestAction::send(
            'DELETE', 
            $this->getEndpointUrl(self::$znamkaId)
        );

        $this->assertEquals(200, $response['statusCode']);
        
        $response = SendRequestAction::send(
            'GET', 
            $this->getEndpointUrl(self::$znamkaId)
        );

        $this->assertEquals(404, $response['statusCode']);
    }

}