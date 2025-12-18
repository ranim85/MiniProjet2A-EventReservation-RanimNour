<?php
require_once __DIR__ . '/../../config/database.php';

class Reservation {
    private $pdo;
    public function __construct() {
        $this->pdo = getPDO();
    }

    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO reservations (event_id, name, email, phone) VALUES (:event_id, :name, :email, :phone)");
        return $stmt->execute([
            'event_id' => $data['event_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);
    }

    public function findByEvent($eventId) {
        $stmt = $this->pdo->prepare("SELECT * FROM reservations WHERE event_id = :id ORDER BY created_at DESC");
        $stmt->execute(['id' => $eventId]);
        return $stmt->fetchAll();
    }
}