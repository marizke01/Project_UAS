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
    private $username;
    private $profile_pic;
    private $db;

    public function __construct(Database $db, $username) {
        $this->db = $db;
        $this->username = $username;
        $this->fetchUserData();
    }

    public function fetchUserData() {
        $conn = $this->db->getConnection();
        $query = "SELECT username, profile_pic FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $this->profile_pic = $user['profile_pic'];
        } else {
            throw new Exception("User data not found.");
        }
    }

    public function getUsername() {
        return $this->username;
    }

    public function getProfilePic() {
        return $this->profile_pic;
    }

    public function updateUsername($new_username) {
        $conn = $this->db->getConnection();
        $update_query = "UPDATE users SET username = ? WHERE username = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ss", $new_username, $this->username);
        $stmt->execute();

        
        $_SESSION['username'] = $new_username;
        $this->username = $new_username;
    }

    public function updateProfilePic($new_profile_pic) {
        $conn = $this->db->getConnection();
        $update_query = "UPDATE users SET profile_pic = ? WHERE username = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ss", $new_profile_pic, $this->username);
        $stmt->execute();

        $this->profile_pic = $new_profile_pic;
    }
}


class Profile {
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function handleFormSubmission($post, $files) {
        if (isset($post['username'])) {
            $new_username = htmlspecialchars(trim($post['username']));
            $this->user->updateUsername($new_username);
        }

        if (isset($files['profile_pic']) && $files['profile_pic']['error'] === UPLOAD_ERR_OK) {
            $profile_pic = $files['profile_pic'];
            $this->handleProfilePicUpload($profile_pic);
        }
    }

    private function handleProfilePicUpload($profile_pic) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($profile_pic['name']);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        
        if (in_array($file_type, ['jpg', 'jpeg', 'png'])) {
            if (move_uploaded_file($profile_pic['tmp_name'], $target_file)) {
                $this->user->updateProfilePic($profile_pic['name']);
            } else {
                throw new Exception("Failed to upload the profile picture.");
            }
        } else {
            throw new Exception("Only JPG, JPEG, and PNG files are allowed.");
        }
    }
}

try {
    if (!isset($_SESSION['username'])) {
        header("Location: login.html");
        exit();
    }

    $username = $_SESSION['username'];
    $db = new Database($conn);
    $user = new User($db, $username);
    $profile = new Profile($user);

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $profile->handleFormSubmission($_POST, $_FILES);
            header("Location: akun.php");
            exit();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    $db->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - MusicApp</title>
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
        .settings-container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .settings-container h2 {
            color: #343a40;
            margin-bottom: 20px;
        }
        .btn-save {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#">MusicApp</a>
        <div class="d-flex gap-2">
            <a href="search.php" class="nav-link">Search</a>
            <a href="premium.php" class="nav-link">Premium</a>
            <a href="collections.php" class="nav-link">Collections</a>
            <a href="akun.php" class="nav-link">Account</a>
            <a href="logout.php" class="nav-link">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="settings-container">
        <h2>Account Settings</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="settings.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user->getUsername()); ?>" required>
            </div>
            <div class="mb-3">
                <label for="profile_pic" class="form-label">Profile Picture</label>
                <input type="file" class="form-control" id="profile_pic" name="profile_pic" accept="image/*">
            </div>
            <button type="submit" class="btn btn-save">Save Changes</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
