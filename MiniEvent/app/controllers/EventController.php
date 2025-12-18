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
        // handled in S3 commit
    }
}