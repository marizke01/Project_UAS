<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

class Database {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function getConnection() {
        return $this->conn;
    }
    public function close() {
        $this->conn->close();
    }
}

class User {
    private $userId;
    public function __construct($userId) {
        $this->userId = $userId;
    }
    public function getUserId() {
        return $this->userId;
    }
}

class PremiumUpgrade {
    private $db;
    private $user;
    public function __construct(Database $db, User $user) {
        $this->db = $db;
        $this->user = $user;
    }
    public function upgrade($payment_method, $account_number, $payment_proof) {
        $userId = $this->user->getUserId();
        
       
        $query = "INSERT INTO premium_subscriptions (account_number, payment_method, payment_proof, status, users_id) VALUES (?, ?, ?, 'active', ?)";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bind_param("ssss", $account_number, $payment_method, $payment_proof, $userId);
        
        if ($stmt->execute()) {
            
            $query2 = "UPDATE users SET is_premium = 1 WHERE users_id = ?";
            $stmt2 = $this->db->getConnection()->prepare($query2);
            $stmt2->bind_param("s", $userId);
            $stmt2->execute();
            return true; 
        }
        return false; 
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = htmlspecialchars(trim($_POST['payment_method']));
    $account_number = htmlspecialchars(trim($_POST['account_number']));
    $userId = $_SESSION['user_id'];
    
   
    $target_dir = "uploads/payment_proofs/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = basename($_FILES["payment_proof"]["name"]);
    $target_file = $target_dir . time() . "_" . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    
    $allowed_types = ["jpg", "jpeg", "png"];
    if (!in_array($imageFileType, $allowed_types)) {
        die("Only JPG, JPEG, and PNG files are allowed.");
    }

    
    if ($_FILES["payment_proof"]["size"] > 2000000) {
        die("File size must be less than 2MB.");
    }

    
    if (!move_uploaded_file($_FILES["payment_proof"]["tmp_name"], $target_file)) {
        die("Failed to upload payment proof.");
    }

    
    $db = new Database($conn);
    $user = new User($userId);
    $premiumUpgrade = new PremiumUpgrade($db, $user);
    $upgrade_success = $premiumUpgrade->upgrade($payment_method, $account_number, $target_file);

    if ($upgrade_success) {
        $_SESSION['is_premium'] = 1;
        header("Location: premium_success.php");
        exit();
    } else {
        echo "Failed to upgrade.";
    }

    
    $db->close();
}
?>
