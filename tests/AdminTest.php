<?php 
namespace tests;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Depends;
use tests\helpers\HelperTrait;
use tests\helpers\SendRequestAction;

class AdminTest extends TestCase {
    use HelperTrait;

    private static array $idBank = [
        'student' => 0,
        'ucitel'  => 0,
        'trida'   => 0,
        'predmet' => 0,
    ];

    // --ACCOUNT TESTS--
    #[Test]
    public function studentAccountCanBeCreated(): void {
        self::$endpoint = 'student';
        $body = [
            "jmeno"     => "testCreate",
            "prijmeni"  => "1111-11-11",
            "trida"     => 1,
        ];

        $response = SendRequestAction::send(
            'POST', 
            $this->getEndpointUrl(), 
            $body
        );

        $this->assertEquals(200, $response['statusCode']);
        $this->assertArrayHasKey('id', $response['body']);

        self::$idBank['student'] = $response['body']['id'];
    }

    #[Test]
    #[Depends('studentAccountCanBeCreated')]
    public function studentAccountCanBeDeleted(): void {
        $response = SendRequestAction::send(
            'DELETE',
            $this->getEndpointUrl(self::$idBank['student'])
        );

        $this->assertEquals(200, $response['statusCode']);
        
        $response = SendRequestAction::send(
            'GET',
            $this->getEndpointUrl(self::$idBank['student'])
        );

        $this->assertEquals(404, $response['statusCode']);

    }
    
     // --TEACHER TESTS--
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

        self::$idBank['ucitel'] = $response['body']['id'];
    }

    #[Test]
    #[Depends('teacherAccountCanBeCreated')]
    public function teacherAccountCanBeDeleted(): void {
        $response = SendRequestAction::send(
            'DELETE',
            $this->getEndpointUrl(self::$idBank['ucitel'])
        );

        $this->assertEquals(200, $response['statusCode']);

        $response = SendRequestAction::send(
            'GET',
            $this->getEndpointUrl(self::$idBank['ucitel'])
        );

        $this->assertEquals(404, $response['statusCode']);

    }

    // --CLASS TESTS--
    #[Test]
    public function classCanBeCreated(): void {
        self::$endpoint = 'trida';
        $body = [ "nazev" => "testCreate" ];

        $response = SendRequestAction::send(
            'POST',
            $this->getEndpointUrl(),
            $body
        );

        $this->assertEquals(200, $response['statusCode']);
        $this->assertArrayHasKey('id', $response['body']);

        self::$idBank['trida'] = $response['body']['id'];
    }

    #[Test]
    #[Depends('classCanBeCreated')]
    public function classCanBeEdited(): void {
        $body = [ "nazev" => "renameTest" ];
        $response = SendRequestAction::send(
            'PATCH', 
            $this->getEndpointUrl(self::$idBank['trida']),
            $body
        );
        ;
        $this->assertEquals(200, $response['statusCode']);
        
        $response = SendRequestAction::send(
            'GET', 
            $this->getEndpointUrl(self::$idBank['trida'])
        );

        $this->assertEquals(200, $response['statusCode']);
        $this->assertNotFalse($response);
        $this->assertEquals($response['body']['nazev'], $body['nazev']);
    }

    #[Test]
    #[Depends('classCanBeCreated')]
    public function classCanBeDeleted(): void {
        $response = SendRequestAction::send(
            'DELETE',
            $this->getEndpointUrl(self::$idBank['trida'])
        );

        $this->assertEquals(200, $response['statusCode']);

        $response = SendRequestAction::send(
            'GET',
            $this->getEndpointUrl(self::$idBank['trida'])
        );

        $this->assertEquals(404, $response['statusCode']);

    }

    // --SUBJECT TESTS--
    #[Test]
    public function subjectCanBeCreated(): void {
        self::$endpoint = 'predmet';
        $body = [ "nazev"=> "testCreate" ];

        $response = SendRequestAction::send(
            'POST',
            $this->getEndpointUrl(),
            $body
        );

        $this->assertEquals(200, $response['statusCode']);
        $this->assertArrayHasKey('id', $response['body']);

        self::$idBank['predmet'] = $response['body']['id'];
    }

    #[Test]
    #[Depends('subjectCanBeCreated')]
    public function subjectCanBeEdited(): void {
        $body = [ "nazev" => "testRename" ];
        $response = SendRequestAction::send(
            'PATCH', 
            $this->getEndpointUrl(self::$idBank['predmet']),
            $body
        );

        $this->assertEquals(200, $response['statusCode']);
        
        $response = SendRequestAction::send(
            'GET', 
            $this->getEndpointUrl(self::$idBank['predmet'])
        );

        $this->assertEquals(200, $response['statusCode']);
        $this->assertNotFalse($response);
        $this->assertEquals($response['body']['nazev'], $body['nazev']);
    }

    #[Test]
    #[Depends('subjectCanBeCreated')]
    public function subjectCanBeDeleted(): void {
        $response = SendRequestAction::send(
            'DELETE',
            $this->getEndpointUrl(self::$idBank['predmet'])
        );

        $this->assertEquals(200, $response['statusCode']);

        $response = SendRequestAction::send(
            'GET',
            $this->getEndpointUrl(self::$idBank['predmet'])
        );

        $this->assertEquals(404, $response['statusCode']);

    }

}