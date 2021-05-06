<?php


namespace unit;


use App\Characters\Beast;
use App\Characters\Hero;
use App\CharactersFactory;
use Exception;
use PHPUnit\Framework\TestCase;

$config = require_once dirname(__FILE__) . "/../../config/properties.php";

class CharactersFactoryTest extends TestCase
{
    private CharactersFactory $factory;

    public function setUp(): void
    {
        $this->factory = new CharactersFactory();
    }

    public function testGetCharacterHero()
    {
        global $config;
        $type = 'hero';
        $name = 'Hero';
        $this->assertInstanceOf(Hero::class, $this->factory->getCharacter($type, $config, $name));
    }

    public function testGetCharacterBeast()
    {
        global $config;
        $type = 'beast';
        $name = 'Beast';
        $this->assertInstanceOf(Beast::class, $this->factory->getCharacter($type, $config, $name));
    }

    public function testFailedGetCharacter()
    {
        global $config;
        $type = 'other';
        $name = 'Other';
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('This character type does not exist');
        $this->factory->getCharacter($type, $config, $name);
    }
}