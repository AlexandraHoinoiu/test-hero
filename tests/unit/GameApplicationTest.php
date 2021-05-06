<?php


namespace unit;


use App\Characters\Beast;
use App\Characters\Hero;
use App\GameApplication;
use Mockery;
use PHPUnit\Framework\TestCase;

class GameApplicationTest extends TestCase
{
    /* @var Mockery\Mock|GameApplication */
    private $application;

    /* @var Mockery\Mock|Hero */
    private $player1;

    /* @var Mockery\Mock|Beast */
    private $player2;

    public function setUp(): void
    {
        parent::setUp();
        $this->application = Mockery::mock(GameApplication::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $this->player1 = Mockery::mock(Hero::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $this->player2 = Mockery::mock(Beast::class)->makePartial()->shouldAllowMockingProtectedMethods();
    }

    /**
     * @param $health1
     * @param $health2
     * @param $alive
     * @dataProvider providerPlayersLive
     */
    public function testPlayersLive($health1, $health2, $alive)
    {
        $this->player1->setHealth($health1);
        $this->player2->setHealth($health2);
        $this->application->setPlayer1($this->player1);
        $this->application->setPlayer2($this->player2);
        $this->assertEquals($alive, $this->application->playersLive());
    }

    public function providerPlayersLive(): array
    {
        return [
            [30, 20, true],
            [0, 10, false],
            [20, 0, false]
        ];
    }

    /**
     * @param $health1
     * @param $health2
     * @param $winner
     * @dataProvider providerDisplayWinner
     */
    public function testDisplayWinner($health1, $health2, $winner)
    {
        $this->player1->setHealth($health1);
        $this->player2->setHealth($health2);
        $this->player1->setName('Player1');
        $this->player2->setName('Player2');
        $this->application->setPlayer1($this->player1);
        $this->application->setPlayer2($this->player2);
        $expectedEcho = "\nThe winner is: " . $winner;
        $this->expectOutputString($expectedEcho);
        $this->application->displayWinner();
    }

    public function providerDisplayWinner(): array
    {
        return [
            [10, 5, 'Player1'],
            [5, 10, 'Player2']
        ];
    }

    public function testSetPlayers1()
    {
        $this->player1->setSpeed(10);
        $this->player2->setSpeed(10);
        $this->player1->setLuck(20);
        $this->player2->setLuck(10);
        $this->application->setPlayers($this->player1, $this->player2);
        $this->assertEquals($this->player1, $this->application->getPlayer1());
    }

    public function testSetPlayers2()
    {
        $this->player1->setSpeed(10);
        $this->player2->setSpeed(10);
        $this->player1->setLuck(10);
        $this->player2->setLuck(20);
        $this->application->setPlayers($this->player1, $this->player2);
        $this->assertEquals($this->player2, $this->application->getPlayer1());
    }

    public function testSetPlayers3()
    {
        $this->player1->setSpeed(20);
        $this->player2->setSpeed(10);
        $this->application->setPlayers($this->player1, $this->player2);
        $this->assertEquals($this->player1, $this->application->getPlayer1());
    }

    public function testSetPlayers4()
    {
        $this->player1->setSpeed(10);
        $this->player2->setSpeed(20);
        $this->application->setPlayers($this->player1, $this->player2);
        $this->assertEquals($this->player2, $this->application->getPlayer1());
    }

    public function testBattle()
    {
        $this->player1->setName('Character');
        $this->player1->shouldReceive('attack')->andReturnNull();
        $this->player2->shouldReceive('attack')->andReturnNull();
        $expectedEcho = 'First attack is done by player ' . $this->player1->getName() . "\n";
        for ($i = 1; $i <= 20; $i++) {
            $expectedEcho = $expectedEcho . 'Round ' . $i . "\n";
        }
        $this->application->setPlayer1($this->player1);
        $this->application->setPlayer2($this->player2);
        $this->application->shouldReceive('playersLive')->andReturn(true);
        $this->expectOutputString($expectedEcho);
        $this->assertNull($this->application->battle());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

}