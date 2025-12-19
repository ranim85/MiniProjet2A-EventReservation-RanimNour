<?php
function get_routes() {
    return [
        'home' => [__DIR__ . '/../app/controllers/HomeController.php', 'index'],
        'events' => [__DIR__ . '/../app/controllers/EventController.php', 'index'],
        'event_details' => [__DIR__ . '/../app/controllers/EventController.php', 'details'],
        'reserve' => [__DIR__ . '/../app/controllers/EventController.php', 'reserve'],
        'admin_login' => [__DIR__ . '/../app/controllers/AdminController.php', 'login'],
        'admin_dashboard' => [__DIR__ . '/../app/controllers/AdminController.php', 'dashboard'],
        // add other routes later
        'admin_logout' => [__DIR__ . '/../app/controllers/AdminController.php', 'logout'],
        'admin_create_event' => [__DIR__ . '/../app/controllers/AdminController.php', 'createEvent'],
        'admin_edit_event' => [__DIR__ . '/../app/controllers/AdminController.php', 'editEvent'],
        'admin_delete_event' => [__DIR__ . '/../app/controllers/AdminController.php', 'deleteEvent'],
        'admin_reservations' => [__DIR__ . '/../app/controllers/AdminController.php', 'reservations'],
        // add other routes later
    ];
}