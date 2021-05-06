<?php


namespace unit\Characters;


use App\Characters\Beast;
use App\Characters\Hero;
use Mockery;
use PHPUnit\Framework\TestCase;

class BeastTest extends TestCase
{
    /* @var Mockery\Mock|Beast */
    private $beast;

    public function setUp(): void
    {
        parent::setUp();
        $this->beast = Mockery::mock(Beast::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $this->beast->setName('Beast');
    }

    public function testSuccessfulAttack()
    {
        $strength = 60;
        $character = Mockery::mock(Hero::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $this->beast->setStrength($strength);
        $character->setLuck(0);
        $character->setDefence(10);
        $character->shouldReceive('getDamage')
            ->withArgs([$strength - $character->getDefence()])
            ->andReturnNull();
        $expectedEcho = $this->beast->getName() . " attacks \n";
        $this->expectOutputString($expectedEcho);
        $this->assertNull($this->beast->attack($character));
    }

    public function testMissAttack()
    {
        $character = Mockery::mock(Hero::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $character->setLuck(100);
        $expectedEcho = $this->beast->getName() . " miss his hit \n";
        $this->expectOutputString($expectedEcho);
        $this->assertNull($this->beast->attack($character));
    }

    /**
     * @param $health
     * @param $damage
     * @param $finalHealth
     * @dataProvider providerGetDamage
     */
    public function testGetDamage($health, $damage, $finalHealth)
    {
        $this->beast->setHealth($health);
        $expectedEcho = 'Damage received by ' . $this->beast->getName() . ': ' . $damage . "\n" .
            'The remaining health: ' . $finalHealth . "\n";
        $this->expectOutputString($expectedEcho);
        $this->beast->getDamage($damage);
        $this->assertEquals($this->beast->getHealth(), $finalHealth);
    }

    public function providerGetDamage(): array
    {
        return [
            [50, 30, 20],
            [30, 40, 0]
        ];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}