<?php

class Akun {
    private $db;

    public function __construct() {
        $this->db = (new Db())->getConnection();
    }

    public function getUser($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->execute([':username' => $username, ':password' => $password]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($username, $password) {
        $stmt = $this->db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        return $stmt->execute([':username' => $username, ':password' => $password]);
    }
}
