<?php

// require __DIR__ . '/vendor/autoload.php';
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();

// echo $_ENV['GOOGLE_MAPS_API_KEY'];

require_once 'autoload.php';

$request = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$parts = explode('/', $request);

$controller = !empty($parts[0]) ? $parts[0] : 'auth';
$action = $parts[1] ?? 'status';
$params = count($parts) > 2 ? array_slice($parts, 2) : [];

$controllerClass = ucfirst($controller) . 'Controller';

$controller = new $controllerClass($action, $params);
$controller->render();
