<?php

require_once ROOT_DIR.'/app/container.php';
$entityManager = $container['entity-manager'];
return $entityManager;


