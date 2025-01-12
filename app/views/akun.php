<?php
session_start();
require_once 'db.php';

class UserAccount
{
    private $db;
    private $username;
    private $userData;

    public function __construct($dbConnection)
    {
        $this->db = $dbConnection;
        $this->checkLogin();
        $this->username = $_SESSION['username'];
        $this->fetchUserData();
    }

    private function checkLogin()
    {
        if (!isset($_SESSION['username'])) {
            header("Location: login.html");
            exit();
        }
    }

    private function fetchUserData()
    {
        $query = "SELECT username, profile_pic FROM users WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $this->userData = $result->fetch_assoc();
        } else {
            echo "User data not found.";
            exit();
        }
    }

    public function getUserData()
    {
        return $this->userData;
    }
}

// Instantiate UserAccount class
$userAccount = new UserAccount($conn);
$userData = $userAccount->getUserData();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - MusicApp</title>
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
        .account-header {
            margin: 30px 0;
        }
        .profile-pic {
            height: 150px;
            width: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #007bff;
        }
        .account-details {
            text-align: center;
            margin-top: 20px;
        }
        .btn-settings, .btn-logout {
            margin-top: 20px;
            width: 200px;
            display: block;
            font-weight: bold;
        }
        .btn-settings {
            background-color: #007bff;
            color: white;
        }
        .btn-logout {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

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

<div class="container mt-4">
    <div class="account-header text-center">
        <img src="uploads/<?php echo htmlspecialchars($userData['profile_pic']); ?>" class="profile-pic" alt="Profile Picture">
        <h2 class="mt-3"><?php echo htmlspecialchars($userData['username']); ?></h2>
        <p>Welcome to your account page. Manage your settings or log out below.</p>
    </div>

    <div class="account-details text-center">
        <a href="settings.php" class="btn btn-settings">Account Settings</a>
        <a href="logout.php" class="btn btn-logout">Logout</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
