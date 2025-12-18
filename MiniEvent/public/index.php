<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/routes.php';

$routes = get_routes();
$route = $_GET['route'] ?? 'home';

if (!isset($routes[$route])) {
    http_response_code(404);
    echo "Route not found";
    exit;
}

list($controllerFile, $action) = $routes[$route];
// controllerFile currently is controller path; require it and create class based on filename
require_once $controllerFile;

// derive class name from filename, e.g. EventController.php => EventController
$base = basename($controllerFile, '.php');
$controllerClass = $base;

$controller = new $controllerClass();
$controller->$action();