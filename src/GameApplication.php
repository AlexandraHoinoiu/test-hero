<?php


namespace App;


use App\Characters\Character;

class GameApplication
{
    private Character $player1;
    private Character $player2;

    public function __construct(Character $playerA, Character $playerB)
    {
        $this->setPlayers($playerA, $playerB);
    }

    public function battle()
    {
        ob_start();
        $turn = 1;
        echo 'First attack is done by player ' . $this->player1->getName() . "\n";
        ob_flush();
        while ($turn <= 20 && $this->playersLive()) {
            echo 'Round ' . $turn;
            echo "\n";
            if ($turn % 2 == 1) {
                $this->player1->attack($this->player2);
            } else {
                $this->player2->attack($this->player1);
            }
            ob_flush();
            $turn++;
        }
        ob_end_flush();
    }

    public function displayWinner(): void
    {
        echo "\n";
        echo 'The winner is: ';
        if ($this->player1->getHealth() > $this->player2->getHealth()) {
            echo $this->player1->getName();
        } else {
            echo $this->player2->getName();
        }
    }

    public function setPlayer1(Character $player1): void
    {
        $this->player1 = $player1;
    }

    public function setPlayer2(Character $player2): void
    {
        $this->player2 = $player2;
    }

    private function setPlayers(Character $playerA, Character $playerB): void
    {
        if ($playerA->getSpeed() == $playerB->getSpeed()) {
            if ($playerA->getLuck() > $playerB->getLuck()) {
                $this->setPlayer1($playerA);
                $this->setPlayer2($playerB);
            } else {
                $this->setPlayer1($playerB);
                $this->setPlayer2($playerA);
            }
        } else {
            if ($playerA->getSpeed() > $playerB->getSpeed()) {
                $this->setPlayer1($playerA);
                $this->setPlayer2($playerB);
            } else {
                $this->setPlayer1($playerB);
                $this->setPlayer2($playerA);
            }
        }
    }

    private function playersLive(): bool
    {
        if ($this->player1->getHealth() <= 0 || $this->player2->getHealth() <= 0) {
            return false;
        }
        return true;
    }
}