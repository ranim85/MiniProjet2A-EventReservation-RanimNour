<?php
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../models/Reservation.php'; // future use

class EventController {
    protected $eventModel;

    public function __construct() {
        $this->eventModel = new Event();
    }

    public function index() {
        $events = $this->eventModel->all();
        require_once __DIR__ . '/../views/partials/header.php';
        require_once __DIR__ . '/../views/events/list.php';
        require_once __DIR__ . '/../views/partials/footer.php';
    }

    public function details() {
        $id = $_GET['id'] ?? null;
        if (!$id) { echo "Événement non trouvé"; exit; }
        $event = $this->eventModel->find($id);
        require_once __DIR__ . '/../views/partials/header.php';
        require_once __DIR__ . '/../views/events/details.php';
        require_once __DIR__ . '/../views/partials/footer.php';
    }

    public function reserve() {
        $id = $_GET['id'] ?? null;
        if (!$id) { echo "ID manquant"; exit; }
        $event = $this->eventModel->find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // will be handled in Commit 13
            // place a redirect or temporary message
            // but to keep flow: include Reservation handling file if exists.
            require_once __DIR__ . '/../models/Reservation.php';
            $reservationModel = new Reservation();
            $data = [
                'event_id' => $id,
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'phone' => $_POST['phone'] ?? '',
            ];
            $reservationModel->create($data);
            $_SESSION['flash'] = 'Réservation enregistrée. Merci !';
            header('Location: /?route=events');
            exit;
        }

        require_once __DIR__ . '/../views/partials/header.php';
        require_once __DIR__ . '/../views/events/reserve.php';
        require_once __DIR__ . '/../views/partials/footer.php';
    }
}