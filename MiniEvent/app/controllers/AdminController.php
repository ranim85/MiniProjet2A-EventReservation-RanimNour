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

    public function createEvent() {
    $this->ensureAuth();
    $eventModel = new Event();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'date' => $_POST['date'],
            'location' => $_POST['location'],
            'seats' => $_POST['seats'] ?? 0,
            'image' => $_POST['image'] ?? '',
        ];
        $eventModel->create($data);
        header('Location: /?route=admin_dashboard');
        exit;
    }
    require_once __DIR__ . '/../views/partials/header.php';
    require_once __DIR__ . '/../views/admin/form_event.php';
    require_once __DIR__ . '/../views/partials/footer.php';
}

public function editEvent() {
    $this->ensureAuth();
    $id = $_GET['id'] ?? null;
    $eventModel = new Event();
    if (!$id) { header('Location: /?route=admin_dashboard'); exit; }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $eventModel->update($id, [
            'title'=>$_POST['title'],
            'description'=>$_POST['description'],
            'date'=>$_POST['date'],
            'location'=>$_POST['location'],
            'seats'=>$_POST['seats'] ?? 0,
            'image'=>$_POST['image'] ?? '',
        ]);
        header('Location: /?route=admin_dashboard');
        exit;
    }

    $event = $eventModel->find($id);
    require_once __DIR__ . '/../views/partials/header.php';
    require_once __DIR__ . '/../views/admin/form_event.php';
    require_once __DIR__ . '/../views/partials/footer.php';
}

public function deleteEvent() {
    $this->ensureAuth();
    $id = $_GET['id'] ?? null;
    if ($id) {
        $ev = new Event();
        $ev->delete($id);
    }
    header('Location: /?route=admin_dashboard');
    exit;
}

public function reservations() {
    $this->ensureAuth();
    $id = $_GET['id'] ?? null;
    $reservationModel = new Reservation();
    $reservations = $reservationModel->findByEvent($id);
    require_once __DIR__ . '/../views/partials/header.php';
    require_once __DIR__ . '/../views/admin/reservations.php';
    require_once __DIR__ . '/../views/partials/footer.php';
}

}
