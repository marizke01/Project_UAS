<?php
// Start session
session_start();
include 'db.php'; // Database connection (dalam hal ini tetap menggunakan koneksi yang sudah ada)

// Kelas Database untuk mengelola koneksi dan query ke database
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

// Kelas Song untuk menangani lagu
class Song {
    private $id;
    private $artist;
    private $title;
    private $url;
    private $coverImage;
    private $isFavorite;
    private $premium;

    public function __construct($id, $artist, $title, $url, $coverImage, $isFavorite, $premium) {
        $this->id = $id;
        $this->artist = $artist;
        $this->title = $title;
        $this->url = $url;
        $this->coverImage = $coverImage;
        $this->isFavorite = $isFavorite;
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
                        if ($this->isFavorite == 0) {
                            echo '<form method="POST">';
                                echo '<input type="hidden" name="favoriteSongId" value="' . $this->id . '">';
                                echo '<button type="submit" class="btn btn-sm fs-1 text-secondary">&hearts;</button>';
                            echo '</form>';
                        } else {
                            echo '<form method="POST">';
                                echo '<input type="hidden" name="unfavoriteSongId" value="' . $this->id . '">';
                                echo '<button type="submit" class="btn btn-sm fs-1 text-danger">&hearts;</button>';
                            echo '</form>';
                        }
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

    public function displaySongs($genre = null) {
        $filter = "";
        
        if ($genre !== null) {
            $filter .= "songs.genre = '$genre'";
        }

        if ($this->isPremium == 0) {
            if ($filter !== "") {
                $filter .= " AND ";
            }
            $filter .= "songs.premium = 0";
        }

        $query = "SELECT songs.id, songs.artist, songs.title, songs.url, songs.cover_image, songs.premium, CASE WHEN favorites.favorites_id IS NOT NULL THEN 1 ELSE 0 END AS isFavorite FROM songs LEFT JOIN favorites ON songs.id = favorites.songs_id WHERE $filter";

        $result = $this->db->query($query);
        while ($row = $result->fetch_assoc()) {
            $song = new Song($row['id'], $row['artist'], $row['title'], $row['url'], $row['cover_image'], $row['isFavorite'], $row['premium']);
            $song->render();
        }
    }
}

if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$userId = $_SESSION['user_id'];
$username = $_SESSION['username'];
$isPremium = $_SESSION['is_premium'];

$db = new Database("localhost", "root", "", "musicapp");
$app = new MusicApp($db, $userId, $isPremium);

if (isset($_POST['favoriteSongId'])) {
    $app->favoriteSong($_POST['favoriteSongId']);
} else if (isset($_POST['unfavoriteSongId'])) {
    $app->unfavoriteSong($_POST['unfavoriteSongId']);
}

$genre = htmlspecialchars($_GET['genre']) ?? 'pop';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pop Songs - MusicApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color:rgb(26, 1, 31);
            font-family: "Arial", sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .navbar {
            background-color: #343a40;
        }
        audio:hover {
            transform: scale(1.05);
            transition: all 0.2s ease-in-out;
        }
        .navbar-brand,
        .nav-link {
            color: white !important;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="home.php">MEGA MUSIC</a>
            <div class="d-flex">
                <a href="logout.php" class="nav-link">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">            
        <h2 class="text-center mb-4 text-white">Popular <?php echo ucfirst($genre); ?> Songs</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            <?php
            
                $app->displaySongs($genre);
            ?>
        </div>
    </div>

    <?php
    
    $db->close();
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
