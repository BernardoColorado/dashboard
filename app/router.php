<?php

$app->get('/', App\Controllers\HomeController::class.':index');
$app->get('/info', App\Controllers\HomeController::class.':info');

$app->get('/file/upload', App\Controllers\FileController::class.':uploadGet');
$app->post('/file/upload', App\Controllers\FileController::class.':uploadPost');

$app->get('/user/signin', App\Controllers\UserController::class.':signinGet');
$app->post('/user/signin', App\Controllers\UserController::class.':signinPost');

$app->get('/user/signout', App\Controllers\UserController::class.':signout');

$app->get('/user/signup', App\Controllers\UserController::class.':signupGet');
$app->post('/user/signup', App\Controllers\UserController::class.':signupPost');

$app->get('/user/activation', App\Controllers\UserController::class.':activationGet');
$app->post('/user/activation', App\Controllers\UserController::class.':activationPost');
$app->get('/user/reactivation', App\Controllers\UserController::class.':reactivation');

$app->get('/user/test', App\Controllers\UserController::class.':test');

