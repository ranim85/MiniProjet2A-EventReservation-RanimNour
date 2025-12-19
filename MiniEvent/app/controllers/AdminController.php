<?php
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../models/Reservation.php';

class AdminController {
    private $adminModel;
    public function __construct() {
        $this->adminModel = new Admin();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $admin = $this->adminModel->findByUsername($username);
            if ($admin && password_verify($password, $admin['password_hash'])) {
                $_SESSION['admin_id'] = $admin['id'];
                header('Location: /?route=admin_dashboard');
                exit;
            } else {
                $error = "Identifiants invalides";
            }
        }
        require_once __DIR__ . '/../views/partials/header.php';
        require_once __DIR__ . '/../views/admin/login.php';
        require_once __DIR__ . '/../views/partials/footer.php';
    }

    public function logout() {
        unset($_SESSION['admin_id']);
        header('Location: /?route=home');
        exit;
    }

    private function ensureAuth() {
        if (empty($_SESSION['admin_id'])) {
            header('Location: /?route=admin_login');
            exit;
        }
    }

    public function dashboard() {
        $this->ensureAuth();
        $eventModel = new Event();
        $events = $eventModel->all();
        require_once __DIR__ . '/../views/partials/header.php';
        require_once __DIR__ . '/../views/admin/dashboard.php';
        require_once __DIR__ . '/../views/partials/footer.php';
    }
}
