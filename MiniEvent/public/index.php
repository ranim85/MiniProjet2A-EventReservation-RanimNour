<?php
// Public front controller (simple router bootstrap)
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/routes.php';

// Very simple router based on ?route=
$route = $_GET['route'] ?? 'home';

$routes = get_routes();

if (!isset($routes[$route])) {
    http_response_code(404);
    echo "Route not found";
    exit;
}

[$controllerFile, $action] = $routes[$route];
require_once $controllerFile;
$controller = new $controllerFile();
$controller->$action();