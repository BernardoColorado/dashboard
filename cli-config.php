<?php
//
define('ROOT_DIR','/var/www/html/dashboard');
//
require_once ROOT_DIR."/vendor/autoload.php";
require_once ROOT_DIR."/config/bootstrap.php";
//
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);