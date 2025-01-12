<?php

session_start();

class Database {
    private $conn;

    public function __construct($host, $username, $password, $dbname) {
        $this->conn = new mysqli($host, $username, $password, $dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function query($sql) {
        return $this->conn->query($sql);
    }

    public function close() {
        $this->conn->close();
    }
}

class Song {
    private $id;
    private $artist;
    private $title;
    private $url;
    private $coverImage;
    private $premium;

    public function __construct($id, $artist, $title, $url, $coverImage, $premium) {
        $this->id = $id;
        $this->artist = $artist;
        $this->title = $title;
        $this->url = $url;
        $this->coverImage = $coverImage;
        $this->premium = $premium == 1 ? "Premium" : "Free";
    }

    public function render() {
        echo '<div class="col">';
            echo '<div class="card w-100 h-100">';
            echo '<div class="position-relative">';
                echo '<img src="' . $this->coverImage . '" class="card-img-top" style="height: 200px; object-fit: cover;">';
                echo '<kbd class="position-absolute top-0 start-0 bg-danger">' . $this->premium . '</kbd>';
            echo '</div>';
                echo '<div class="card-body">';
                    echo '<div class="d-flex justify-content-between align-items-center mb-2">';
                        echo '<div>';
                            echo '<h5 class="card-title">' . $this->title . '</h5>';
                            echo '<p class="card-text">' . $this->artist . '</p>';
                        echo '</div>';
                        echo '<form method="POST">';
                            echo '<input type="hidden" name="unfavoriteSongId" value="' . $this->id . '">';
                            echo '<button type="submit" class="btn btn-sm fs-1 text-danger">&hearts;</button>';
                        echo '</form>';
                    echo '</div>';
                    echo '<audio controls class="w-100">';
                        echo '<source src="' . $this->url . '" type="audio/mp3">';
                        echo 'Your browser does not support the audio element.';
                    echo '</audio>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
}

class MusicApp {
    private $db;
    private $userId;
    private $isPremium;

    public function __construct($db, $userId, $isPremium) {
        $this->db = $db;
        $this->userId = $userId;
        $this->isPremium = $isPremium;
    }

    public function favoriteSong($id) {
        $this->db->query("INSERT INTO favorites (songs_id, users_id) VALUES ($id, '$this->userId')");
    }

    public function unfavoriteSong($id) {
        $this->db->query("DELETE FROM favorites WHERE songs_id = $id AND users_id = '$this->userId'");
    }

    public function displaySongs() {
        $isPremium = $this->isPremium == 0 ? "WHERE songs.premium = 0" : "";
        $result = $this->db->query("SELECT songs.id, songs.artist, songs.title, songs.url, songs.cover_image, songs.premium FROM songs JOIN favorites ON songs.id = favorites.songs_id AND favorites.users_id = '$this->userId' $isPremium");
        while ($row = $result->fetch_assoc()) {
            $song = new Song($row['id'], $row['artist'], $row['title'], $row['url'], $row['cover_image'], $row['premium']);
            $song->render();
        }
    }
}

if (!isset($_SESSION['username']) || !isset($_SESSION['user_id']) || !isset($_SESSION['is_premium'])) {
    header("Location: login.html");
    exit();
}

$userId = $_SESSION['user_id'];
$username = $_SESSION['username'];
$isPremium = $_SESSION['is_premium'];

// Inisialisasi database dan aplikasi
$db = new Database("localhost", "root", "", "musicapp");
$app = new MusicApp($db, $userId, $isPremium);

if (isset($_POST['favoriteSongId'])) {
    $app->favoriteSong($_POST['favoriteSongId']);
} else if (isset($_POST['unfavoriteSongId'])) {
    $app->unfavoriteSong($_POST['unfavoriteSongId']);
}

class MusicCollection {
    public function renderNavBar() {
        echo '<nav class="navbar navbar-expand-lg navbar-dark">';
        echo '<div class="container">';
        echo '<a class="navbar-brand" href="home.php">MEGA MUSIC</a>';
        echo '<div class="d-flex gap-2">';
        echo '<a href="search.php" class="nav-link">Search</a>';
        echo '<a href="premium.php" class="nav-link">Premium</a>';
        echo '<a href="collections.php" class="nav-link">Collections</a>';
        echo '<a href="akun.php" class="nav-link">Account</a>';
        echo '<a href="logout.php" class="nav-link">Logout</a>';
        echo '</div></div></nav>';
    }

    public function renderSectionHeader($title) {
        echo '<div class="section-header text-center">';
            echo '<h2>' . htmlspecialchars($title) . '</h2>';
        echo '</div>';
    }
}

$musicCollection = new MusicCollection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Collection - MusicApp</title>
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
        .section-header {
            margin: 30px 0;
        }
        .music-card img {
            height: 100px;
            object-fit: cover;
        }
        .favorite-icon {
            font-size: 24px;
            color: red;
            cursor: pointer;
        }
        .favorite-icon.liked {
            color: gold;
        }
    </style>
</head>
<body>

<?php $musicCollection->renderNavBar(); ?>

<div class="container mt-4">
    <?php $musicCollection->renderSectionHeader('Favorite Songs'); ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
        <?php
            $app->displaySongs();
            $db->close()
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
