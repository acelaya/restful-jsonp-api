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

$app->map('/users(/:id)', UsersController::class . ':dispatch')
    ->via('GET', 'POST', 'PUT', 'DELETE')
    ->name('users-rest');

$app->run();
