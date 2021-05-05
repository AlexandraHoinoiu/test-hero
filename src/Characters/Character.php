<?php


namespace App\Characters;


abstract class Character
{
    protected string $name;
    protected float $health;
    protected float $strength;
    protected float $defence;
    protected float $speed;
    protected float $luck;

    public function __construct($config, $name)
    {
        $this->setName($name);
        $this->setHealth(rand($config['health'][0], $config['health'][1]));
        $this->setStrength(rand($config['strength'][0], $config['strength'][1]));
        $this->setDefence(rand($config['defence'][0], $config['defence'][1]));
        $this->setSpeed(rand($config['speed'][0], $config['speed'][1]));
        $this->setLuck(rand($config['luck'][0], $config['luck'][1]));
    }

    abstract function attack(Character $character): void;

    abstract function getDamage(float $damage): void;

    public function setHealth(float $health): void
    {
        $this->health = $health;
    }

    public function setStrength(float $strength): void
    {
        $this->strength = $strength;
    }

    public function setDefence(float $defence): void
    {
        $this->defence = $defence;
    }

    public function setSpeed(float $speed): void
    {
        $this->speed = $speed;
    }

    public function setLuck(float $luck): void
    {
        $this->luck = $luck;
    }

    public function getSpeed(): float
    {
        return $this->speed;
    }

    public function getLuck(): float
    {
        return $this->luck;
    }

    public function getHealth(): float
    {
        return $this->health;
    }

    public function getDefence(): float
    {
        return $this->defence;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

}