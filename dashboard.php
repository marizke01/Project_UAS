<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
    <a href="logout.php">Logout</a>

    <h2>Music Library</h2>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Artist</th>
                <th>Play</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM songs";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['title']}</td>
                        <td>{$row['artist']}</td>
                        <td><a href='{$row['url']}' target='_blank'>Play</a></td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
