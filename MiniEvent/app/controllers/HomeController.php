<?php
class __DIR__ {} // placeholder to satisfy require pattern; real autoload would be better
class HomeController {
    public function index() {
        require_once __DIR__ . '/../views/partials/header.php';
        require_once __DIR__ . '/../views/home.php';
        require_once __DIR__ . '/../views/partials/footer.php';
    }
}