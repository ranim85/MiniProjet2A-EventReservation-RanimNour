<?php
require_once __DIR__ . '/../../config/database.php';

class Admin {
    private $pdo;
    public function __construct() {
        $this->pdo = getPDO();
    }

    public function findByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM admin WHERE username = :u");
        $stmt->execute(['u' => $username]);
        return $stmt->fetch();
    }
}
