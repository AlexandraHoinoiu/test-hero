<?php


namespace unit\Characters;


use App\Characters\Beast;
use App\Characters\Hero;
use Mockery;
use PHPUnit\Framework\TestCase;

class HeroTest extends TestCase
{
    /* @var Mockery\Mock|Hero */
    private $hero;

    public function setUp(): void
    {
        parent::setUp();
        $this->hero = Mockery::mock(Hero::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $this->hero->setName('Hero');
    }

    public function testSuccessfulAttackWithoutRapidStrike()
    {
        $strength = 60;
        $character = Mockery::mock(Beast::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $this->hero->setStrength($strength);
        $character->setLuck(0);
        $character->setDefence(10);
        $this->hero->setRapidStrike(0);
        $character->shouldReceive('getDamage')
            ->withArgs([$strength - $character->getDefence()])
            ->andReturnNull();
        $expectedEcho = $this->hero->getName() . " attacks \n";
        $this->expectOutputString($expectedEcho);
        $this->assertNull($this->hero->attack($character));
    }

    public function testSuccessfulAttackWithRapidStrike()
    {
        $strength = 60;
        $character = Mockery::mock(Beast::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $this->hero->setStrength($strength);
        $character->setLuck(0);
        $character->setDefence(10);
        $this->hero->setRapidStrike(100);
        $character->shouldReceive('getDamage')
            ->withArgs([($strength - $character->getDefence()) * 2])
            ->andReturnNull();
        $expectedEcho = $this->hero->getName() . " attacks \n" .
            $this->hero->getName() . " use rapid strike \n";;
        $this->expectOutputString($expectedEcho);
        $this->assertNull($this->hero->attack($character));
    }

    public function testMissAttack()
    {
        $character = Mockery::mock(Hero::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $character->setLuck(100);
        $expectedEcho = $this->hero->getName() . " miss his hit \n";
        $this->expectOutputString($expectedEcho);
        $this->assertNull($this->hero->attack($character));
    }

    /**
     * @param $health
     * @param $damage
     * @param $finalHealth
     * @dataProvider providerGetDamage
     */
    public function testGetDamageWithoutMagicShield($health, $damage, $finalHealth)
    {
        $this->hero->setMagicShield(0);
        $this->hero->setHealth($health);
        $expectedEcho = 'Damage received by ' . $this->hero->getName() . ': ' . $damage . "\n" .
            'The remaining health: ' . $finalHealth . "\n";
        $this->expectOutputString($expectedEcho);
        $this->hero->getDamage($damage);
        $this->assertEquals($this->hero->getHealth(), $finalHealth);
    }

    public function providerGetDamage(): array
    {
        return [
            [50, 30, 20],
            [30, 40, 0]
        ];
    }

    /**
     * @param $health
     * @param $damage
     * @dataProvider providerGetDamage
     */
    public function testGetDamageWithMagicShield($health, $damage)
    {
        $finalHealth = $health - $damage / 2;
        $this->hero->setMagicShield(100);
        $this->hero->setHealth($health);
        $expectedEcho = $this->hero->getName() . " use magic shield \n" .
            'Damage received by ' . $this->hero->getName() . ': ' . $damage / 2 . "\n" .
            'The remaining health: ' . $finalHealth . "\n";
        $this->expectOutputString($expectedEcho);
        $this->hero->getDamage($damage);
        $this->assertEquals($this->hero->getHealth(), $finalHealth);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}