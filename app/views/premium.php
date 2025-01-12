<?php

session_start();

include 'db.php';

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
    private $isPremium;

    public function __construct($userId, $isPremium) {
        $this->userId = $userId;
        $this->isPremium = $isPremium;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getIsPremium() {
        return $this->isPremium;
    }
}

class Navbar {
    public function render() {
        echo '
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="#">MEGA MUSIC</a>
                <div class="d-flex gap-2">
                    <a href="search.php" class="nav-link">Search</a>
                    <a href="premium.php" class="nav-link">Premium</a>
                    <a href="collections.php" class="nav-link">Collections</a>
                    <a href="akun.php" class="nav-link">Account</a>
                    <a href="logout.php" class="nav-link">Logout</a>
                </div>
            </div>
        </nav>
        ';
    }
}


class PremiumPage {
    private $db;
    private $user;
    private $navbar;

    public function __construct($db, $user) {
        $this->db = $db;
        $this->user = $user;
        $this->navbar = new Navbar();
    }

    private function upgradeToPremium() {
        $isPremium = $this->user->getIsPremium();

        if ($isPremium == 1) {
            echo '
                <div class="premium-header text-center">
                    <h2>You are already a Premium Member</h2>
                    <p>You can access more songs now!</p>
                </div>
            ';
        } else {
            echo '
                <div class="premium-header text-center">
                    <h2>Upgrade to Premium</h2>
                    <p>Access more songs for only Rp 10,000/month!</p>
                    <a href="updrade_premium.php" class="btn btn-primary">Upgrade Now</a>
                </div>
                <div class="text-center mt-5">
                    <h5>Payment Methods</h5>
                    <p>BCA | BSI | Mandiri</p>
                </div>
            ';
        }
    }

    public function render() {
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Premium - MusicApp</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
            <style>
                body {
                    background-color: #f8f9fa;
                }
                .navbar {
                    background-color: #343a40;
                }
                .navbar-brand, .nav-link {
                    color: white !important;
                }
            </style>
        </head>
        <body class="d-flex flex-column min-vh-100">';

      
        $this->navbar->render();
        
        echo '<div class="container flex-grow-1 d-flex align-items-center justify-content-center">';
            echo '<div>';
                $this->upgradeToPremium();
            echo '</div>';
        echo '</div>';
        

        echo '
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        ';
    }
}


if (!isset($_SESSION['username']) || !isset($_SESSION['user_id']) || !isset($_SESSION['is_premium'])) {
    header("Location: login.html");
    exit();
}

$userId = $_SESSION['user_id'];
$isPremium = $_SESSION['is_premium'];

$db = new Database($conn);
$user = new User($userId, $isPremium);
$premiumPage = new PremiumPage($db, $user);

$premiumPage->render();
?>
