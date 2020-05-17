<?php

require_once ROOT_DIR.'/app/container.php';

$entityManager = $container['entity-manager'];

/*
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array("src/Models/ORM/Entities"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

//conexion
$conn = array(
  'driver'   => 'pdo_mysql',
  'user'     => 'root',
  'password' => 'feH@haG5822',
  'dbname'   => 'foo',
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
*/

return $entityManager;


