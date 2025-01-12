<?php
session_start();

class User {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function login($username, $password) {
        $username = $this->conn->real_escape_string($username);

        // Query to fetch user data
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['users_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['profile_pic'] = $user['profile_pic'];
                $_SESSION['is_premium'] = $user['is_premium'];
                $this->redirectWithMessage('Login successful!', '/app/views/home.php');
            } else {
                $this->redirectWithMessage('Incorrect password.', 'login.html');
            }
        } else {
            $this->redirectWithMessage('User not found.', 'login.html');
        }

        $stmt->close();
    }

    private function redirectWithMessage($message, $location) {
        echo "<script>alert('$message'); window.location.href='$location';</script>";
        exit;
    }
}

// Include database connection
include_once __DIR__ . '/../app/models/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Instantiate User class
    $user = new User($conn);
    $user->login($username, $password);
}

$conn->close();
?>
