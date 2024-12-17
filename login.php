<?php 
session_start();
include 'db.php';

$errorMessage = ""; // Variabel untuk menampilkan pesan kesalahan

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi input
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = htmlspecialchars(trim($_POST['username']));
        $password = trim($_POST['password']);

        // Cek apakah user ada di database
        $sql = "SELECT * FROM users WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Login berhasil
                $_SESSION['username'] = $username;
                setcookie("user", $username, time() + (86400 * 30), "/"); // Cookie 30 hari
                header('Location: index.php');
                exit;
            } else {
                $errorMessage = "Password salah!";
            }
        } else {
            $errorMessage = "Username tidak ditemukan!";
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
    <title>Login</title>
</head>
<body>
    <form method="POST" action="">
        <h2>Login</h2>
        <?php if (!empty($errorMessage)): ?>
            <p style="color: red;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </form>
</body>
</html>
