<?php
session_start();

class User {
    private $username;
    public function __construct() {
        if (isset($_SESSION['username'])) {
            $this->username = $_SESSION['username'];
        } else {
            header("Location: home.php");
            exit();
        }
    }
    public function getUsername() {
        return $this->username;
    }
}

$user = new User();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upgrade Successful</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Congratulations, <?php echo htmlspecialchars($user->getUsername()); ?>!</h1>
        <p>Your account has been successfully upgraded to <b>Premium</b>.</p>
        <p>Enjoy unlimited access to premium features!</p>
        <a href="home.php" class="btn btn-primary">Go to Home</a>
    </div>
</body>
</html>
