<?php

use App\CharactersFactory;
use App\GameApplication;

require dirname(__FILE__) . "/../autoload.php";

header('Content-Type: text/plain');

try {
    $config = require_once dirname(__FILE__) . "/../config/properties.php";

    $charactersFactory = new CharactersFactory();
    $Orderus = $charactersFactory->getCharacter('hero', $config, 'Orderus');
    $beast = $charactersFactory->getCharacter('beast', $config, 'Beast');
    $game = new GameApplication($Orderus, $beast);
    $game->battle();
    $game->displayWinner();
} catch (Exception $e) {
    echo "\n";
    echo $e->getMessage() . " - file: " . $e->getFile() . " - line:" . $e->getLine();
}
