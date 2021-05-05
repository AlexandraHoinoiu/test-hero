<?php

// Determine repository root
const ROOT_DIR = __DIR__ . DIRECTORY_SEPARATOR;
const CONFIG_DIR = ROOT_DIR . "config/";

// autoload
if (!file_exists(ROOT_DIR . 'vendor/autoload.php')) {
    die("Please run 'composer install' command");
}
require_once ROOT_DIR . 'vendor/autoload.php';
