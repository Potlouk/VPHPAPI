<?php 
namespace tests;
use PHPUnit\Framework\TestCase;
use src\factories\ZnamkaModelFactory;
use src\models\ZnamkaModel;

class UcitelTStudentTest extends TestCase {
    private static int $znamkaId;
    /** @test */
    public function createGradeTest(): void {
        //jen mail ?
        $body = [
            "poznamka"    => "testCreate",
            "zapsano"     => "1111-11-11",
            "znamka"      => 1,
            "Studenti_Id" => 9,
            "Predmety_Id" => 1
        ];

        $response = SendRequestAction::send('POST', "znamka", $body);
        $this->assertEquals(200, $response['statusCode']);
        $this->assertArrayHasKey('id', $response['body']);

        self::$znamkaId = $response['body']['id'];
    }

    /**
     * @depends createGradeTest
     * @test
     */
    public function patchGradeTest(): void {
        $body = [
            "znamka" => 5,
        ];

        $response = SendRequestAction::send('PATCH', "znamka/".self::$znamkaId, $body);
        $this->assertEquals(200, $response['statusCode']);
        
        $response = SendRequestAction::send('GET', "znamka/".self::$znamkaId);
        $this->assertEquals(200, $response['statusCode']);

        $this->assertNotFalse($response);
        $this->assertEquals($response['body']['znamka'], 5);
    }
    /**
     * @depends patchGradeTest
     * @test
     */
    public function deleteGradeTest(): void {
        $response = SendRequestAction::send('DELETE', "znamka/".self::$znamkaId);
        $this->assertEquals(200, $response['statusCode']);
        
        $response = SendRequestAction::send('GET', "znamka/".self::$znamkaId);
        $this->assertEquals(500, $response['statusCode']);
    }
}