<?php
ini_set('display_errors', 'on');

require_once __DIR__ . '/../vendor/autoload.php';

use edustef\mvcFrame\Application;
use app\controllers\UserController;
use app\controllers\JuegoController;
use app\models\UserModel;


$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
  'userClass' => UserModel::class,
  'db' => [
    'dsn' => $_ENV['DB_DSN'],
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD']
  ],
  'defaultLayout' => 'main'
];

$app = new Application(dirname(__DIR__) . '/src/', $config);

$app->router->get('/', 'home');

$app->router->get('/juegaciam', [JuegoController::class, 'juegaciam']);
$app->router->post('/juegaciam', [JuegoController::class, 'juegaciam']);

$app->router->get('/login', [UserController::class, 'login']);
$app->router->post('/login', [UserController::class, 'login']);


$app->router->get('/logout', [UserController::class, 'logout']);


$app->router->get('/signup', [UserController::class, 'signup']);
$app->router->post('/signup', [UserController::class, 'signup']);

$app->run();
