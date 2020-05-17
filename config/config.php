<?php

$json = file_get_contents(ROOT_DIR.'/config/config.json');
$app_config=json_decode($json,true);
return $app_config;


