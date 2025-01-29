<?php 
namespace tests;
use PHPUnit\Framework\TestCase;
use src\factories\StudentModelFactory;
use src\factories\UcitelModelFactory;
use src\models\StudentModel;
use src\models\UcitelModel;

class AdminTest extends TestCase {
    private int $studentId;
    private int $ucitelId;
     /** @test */
    public function createStudentTest(): void {
        $body = [
            "jmeno"     => "testCreate",
            "prijmeni"  => "1111-11-11",
            "trida" => 1,
        ];

        $response = SendRequestAction::send('POST', "student", $body);

        $this->assertEquals(200, $response['statusCode']);
        $this->assertArrayHasKey('id', $response['body']);

        $this->studentId = $response['body']['id'];
    }

    /**
     * @depends createStudentTest
     */
    public function deleteStudentTest(): void {
        $response = SendRequestAction::send('DELETE', "student/{$this->studentId}");
        $this->assertEquals(200, $response['statusCode']);
        
        $student = new StudentModel();
        $student = $student->find($this->studentId);
        
        $this->assertFalse($student);
    }
   /** @test */
    public function createUcitelTest(): void {
        $body = [
            "jmeno"     => "testCreate",
            "trida_Id"  => 1,
        ];

        $response = SendRequestAction::send('POST', "ucitel", $body);
        $this->assertEquals(200, $response['statusCode']);
        $this->assertArrayHasKey('id', $response['body']);

        $this->ucitelId = $response['body']['id'];
    }
    /**
     * @depends createUcitelTest
     */
    public function deleteUcitelTest(): void {
        $response = SendRequestAction::send('DELETE', "ucitel/{$this->ucitelId}");
        $this->assertEquals(200, $response['statusCode']);
        
        $ucitel = new UcitelModel();
        $ucitel = $ucitel->find($this->ucitelId);
        
        $this->assertFalse($ucitel);
    }
}