<?php


namespace App\Characters;


class Hero extends Character
{

    private float $rapidStrike;
    private float $magicShield;

    function __construct($config, $name)
    {
        parent::__construct($config, $name);
        $this->setRapidStrike($config['rapidStrike']);
        $this->setMagicShield($config['magicShield']);
    }

    function attack(Character $character): void
    {
        if (rand(0, 100) >= $character->getLuck()) {
            echo $this->name . " attacks \n";
            $damage = $this->strength - $character->getDefence();
            if (rand(0, 100) <= $this->rapidStrike) {
                $damage = $damage * 2;
                echo $this->name . " use rapid strike \n";
            }
            $character->getDamage($damage);
        } else {
            echo $this->name . " miss his hit \n";
        }
    }

    function getDamage(float $damage): void
    {
        if (rand(0, 100) <= $this->magicShield) {
            echo $this->name . " use magic shield \n";
            $this->health = $this->health - $damage / 2;
            echo 'Damage received by ' . $this->name . ': ' . $damage / 2 . "\n";
        } else {
            $this->health = $this->health - $damage;
            echo 'Damage received by ' . $this->name . ': ' . $damage . "\n";
        }
        if ($this->health <= 0) {
            $this->health = 0;
        }
        echo 'The remaining health: ' . $this->health . "\n";
    }

    public function setRapidStrike(float $rapidStrike): void
    {
        $this->rapidStrike = $rapidStrike;
    }

    public function setMagicShield(float $magicShield): void
    {
        $this->magicShield = $magicShield;
    }
}