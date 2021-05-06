<?php


namespace App;


use App\Characters\Beast;
use App\Characters\Character;
use App\Characters\Hero;
use Exception;

class CharactersFactory
{
    /**
     * @throws Exception
     */
    public function getCharacter($type, $config, $name): Character
    {
        switch ($type) {
            case "hero":
                return new Hero($config[$type], $name);
            case "beast":
                return new Beast($config[$type], $name);
            default:
                throw new Exception("This character type does not exist");
        }
    }
}