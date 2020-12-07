<?php
ini_set('display_errors', 'on');

require_once __DIR__ . '/../vendor/autoload.php';

use edustef\mvcFrame\Application;
use app\controllers\UserController;
use app\models\User;


$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
  'userClass' => User::class,
  'db' => [
    'dsn' => $_ENV['DB_DSN'],
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD']
  ]
];

$app = new Application(dirname(__DIR__) . '/src/', $config);

$app->router->get('/', 'home');

$app->router->get('/juegaciam', 'juegaciam');
$app->router->post('/juegaciam', 'juegaciam');

$app->router->get('/login', [UserController::class, 'login']);
$app->router->post('/login', [UserController::class, 'login']);


$app->router->get('/signup', [UserController::class, 'signup']);
$app->router->post('/signup', [UserController::class, 'signup']);

$app->run();
