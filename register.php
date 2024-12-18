<?php
session_start();
require_once 'db.php'; 

$errorMessage = ""; 

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['username']) && !empty($_POST['password']) && isset($_FILES['profile_picture'])) {
        $username = htmlspecialchars(trim($_POST['username']));
        $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $profilePicture = $_FILES['profile_picture'];
        $extension = strtolower(pathinfo($profilePicture['name'], PATHINFO_EXTENSION));

        if (in_array($extension, $allowedExtensions)) {
            $uploadDir = "uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true); 
            }
            $fileName = uniqid() . "." . $extension;
            $uploadPath = $uploadDir . $fileName;

            if (move_uploaded_file($profilePicture['tmp_name'], $uploadPath)) {
                
                $sql = "INSERT INTO users (username, password, profile_picture) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $username, $password, $fileName);

                if ($stmt->execute()) {
                    $_SESSION['username'] = $username;
                    header('Location: index.php');
                    exit;
                } else {
                    $errorMessage = "Terjadi kesalahan saat menyimpan data ke database!";
                }

                $stmt->close();
            } else {
                $errorMessage = "Gagal mengunggah gambar!";
            }
        } else {
            $errorMessage = "Format gambar tidak valid! (Hanya jpg, jpeg, png, gif)";
        }
    } else {
        $errorMessage = "Semua kolom harus diisi!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style2.css">
    <title>Register</title>
</head>
<body>
    <form method="POST" action="" enctype="multipart/form-data">
        <h2>Register</h2>
        <?php if (!empty($errorMessage)): ?>
            <p style="color: red;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="file" name="profile_picture" accept="image/*" required>
        <button type="submit">Register</button>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </form>
</body>
</html>
