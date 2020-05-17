<?php
//
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set("memory_limit","2560M");
error_reporting(E_ALL);

define('ROOT_DIR','/var/www/html/dashboard');

require_once ROOT_DIR."/vendor/autoload.php";
require_once ROOT_DIR."/app/main.php";

