<?php


namespace App\Characters;


class Beast extends Character
{
    function attack(Character $character): void
    {
        if (rand(0, 100) >= $character->getLuck()) {
            echo $this->name . " attacks \n";
            $damage = $this->strength - $character->getDefence();
            $character->getDamage($damage);
        } else {
            echo $this->name . " miss his hit \n";
        }
    }

    function getDamage(float $damage): void
    {
        echo 'Damage received by ' . $this->name . ': ' . $damage . "\n";
        $this->health = $this->health - $damage;
        if ($this->health <= 0) {
            $this->health = 0;
        }
        echo 'The remaining health: ' . $this->health . "\n";
    }
}