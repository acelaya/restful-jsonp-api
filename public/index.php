<?php
use Acelaya\Controller\UsersController;
use RKA\Slim;

include __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$app = new Slim();

$app->map('/', function () {
    echo 'Home';
})->via('GET');

$app->any('/users(/:id)', UsersController::class . ':dispatch')
    ->name('users-rest');

$app->run();
