<?php
//
require_once ROOT_DIR.'/app/container.php';
$app = new \Slim\App($container);
require_once ROOT_DIR.'/app/router.php';
$app->run();