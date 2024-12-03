<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-page">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <img src="images/logo2.png" alt="Logo">
            <h1>MusicApp</h1>
        </div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Search</a></li>
                <li><a href="#">Your Library</a></li>
            </ul>
        </nav>
        <footer>
            <a href="logout.php">Logout</a>
        </footer>
    </aside>

    <!-- Main Content -->
    <main class="content">
        <header>
            <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
        </header>
        <section class="playlists">
            <h3>Your Playlists</h3>
            <div class="playlist-grid">
                <div class="playlist">
                    <img src="images/playlist1.jpg" alt="Playlist 1">
                    <p>Chill Beats</p>
                </div>
                <div class="playlist">
                    <img src="images/playlist2.jpg" alt="Playlist 2">
                    <p>Workout Mix</p>
                </div>
                <!-- Add more playlists as needed -->
            </div>
        </section>
    </main>

    <!-- Music Player -->
    <footer class="music-player">
        <div class="player-info">
            <p>Now Playing: <strong>Song Title</strong> by <strong>Artist</strong></p>
        </div>
        <div class="player-controls">
            <button>⏮</button>
            <button>▶</button>
            <button>⏭</button>
        </div>
    </footer>
</body>
</html>
