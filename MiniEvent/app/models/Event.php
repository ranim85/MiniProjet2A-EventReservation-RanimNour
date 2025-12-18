<?php
require_once __DIR__ . '/../../config/database.php';

class Event {
    private $pdo;

    public function __construct() {
        $this->pdo = getPDO();
    }

    public function all() {
        $stmt = $this->pdo->query("SELECT * FROM events ORDER BY date ASC");
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM events WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO events (title, description, date, location, seats, image) VALUES (:title,:description,:date,:location,:seats,:image)");
        $stmt->execute($data);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $data) {
        $data['id'] = $id;
        $stmt = $this->pdo->prepare("UPDATE events SET title=:title, description=:description, date=:date, location=:location, seats=:seats, image=:image WHERE id=:id");
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM events WHERE id=:id");
        return $stmt->execute(['id' => $id]);
    }
}