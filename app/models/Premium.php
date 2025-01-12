<?php

class Premium {
    private $db;

    public function __construct() {
        $this->db = (new Db())->getConnection();
    }

    public function upgradeToPremium($username, $paymentMethod, $accountNumber) {
        $stmt = $this->db->prepare("UPDATE users SET premium = 1 WHERE username = :username");
        return $stmt->execute([':username' => $username]);
    }
}
