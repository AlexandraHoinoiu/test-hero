<?php

use App\Characters\Beast;
use App\Characters\Hero;
use App\GameApplication;

require dirname(__FILE__)."/../autoload.php";

header('Content-Type: text/plain');

$config = require_once dirname(__FILE__)."/../config/properties.php";

$Orderus = new Hero($config['hero'], 'Orderus');
$beast = new Beast($config['beast'], 'Beast');
$game = new GameApplication($Orderus, $beast);
$game->battle();
$game->displayWinner();