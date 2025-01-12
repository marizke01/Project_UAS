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


class Song {
    private $artist;
    private $title;
    private $url;
    private $premium;

    public function __construct($artist, $title, $url, $premium) {
        $this->artist = $artist;
        $this->title = $title;
        $this->url = $url;
        $this->premium = $premium == 1 ? "Premium" : "Free";
    }

    public function getArtist() {
        return $this->artist;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getUrl() {
        return $this->url;
    }

    public function isPremium() {
        return $this->premium;
    }

    public static function searchSongs(Database $db, $search, $isPremiumUser) {
        $conn = $db->getConnection();
        $premium = $isPremiumUser == 0 ? "AND premium = 0" : "";
        $query = "SELECT * FROM songs WHERE title LIKE '%$search%' $premium";
        $result = $conn->query($query);
        
        $songs = [];
        while ($row = $result->fetch_assoc()) {
            $songs[] = new Song($row['artist'], $row['title'], $row['url'], $row['premium']);
        }
        return $songs;
    }

    public static function getAllSongs(Database $db, $isPremiumUser) {
        $conn = $db->getConnection();
        $premium = $isPremiumUser == 0 ? "WHERE premium = 0" : "";
        $query = "SELECT * FROM songs $premium";
        $result = $conn->query($query);

        $songs = [];
        while ($row = $result->fetch_assoc()) {
            $songs[] = new Song($row['artist'], $row['title'], $row['url'], $row['premium']);
        }
        return $songs;
    }
}


class Search {
    private $db;
    private $searchTerm;
    private $isPremiumUser;

    public function __construct(Database $db, $searchTerm, $isPremiumUser) {
        $this->db = $db;
        $this->searchTerm = $searchTerm;
        $this->isPremiumUser = $isPremiumUser;
    }

    public function executeSearch() {
        if (!empty($this->searchTerm)) {
            return Song::searchSongs($this->db, $this->searchTerm, $this->isPremiumUser);
        }
        return Song::getAllSongs($this->db, $this->isPremiumUser);
    }
}

if(!isset($_SESSION['is_premium']) ) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search - MusicApp</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color:rgb(52, 4, 47);
        }
        .navbar {
            background-color: #343a40;
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .song-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: #fff;
        }
        .song-card h5 {
            margin: 0;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
                <a class="navbar-brand" href="home.php">MEGA MUSIC</a>
                <div class="d-flex gap-2">
                    <a href="search.php" class="nav-link">Search</a>
                    <a href="premium.php" class="nav-link">Premium</a>
                    <a href="collections.php" class="nav-link">Collections</a>
                    <a href="akun.php" class="nav-link">Account</a>
                    <a href="logout.php" class="nav-link">Logout</a>
                </div>
        </div>
    </nav>

    <div class="container mt-4 ">
        <h2 class="text-center text-white">Search Music</h2>
        <div class="mt-3 mb-2">
            <form method="GET">
                <div class="row">
                    <div class="col-11">
                        <input type="text" class="form-control" id="searchInput" name="search" placeholder="Search for songs...">
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary w-100">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div>
        <?php
            $isPremiumUser = $_SESSION['is_premium'];

            $searchTerm = isset($_GET['search']) ? htmlspecialchars(trim($_GET['search'])) : "";

            $db = new Database($conn);
            $search = new Search($db, $searchTerm, $isPremiumUser);
            $songs = $search->executeSearch();

            if (!empty($searchTerm)) {
                echo '<p class="text-center mb-4">Results for: ' . $searchTerm . '</p>';
            }

            foreach ($songs as $song) {
                echo '<div class="song-card">';
                    echo '<h5>' . $song->getTitle() . '</h5>';
                    echo '<p class="m-0">' . $song->getArtist() . '</p>';
                    echo '<p class="m-0">' . $song->isPremium() . '</p>';
                    echo '<audio controls>';
                        echo '<source src="' . $song->getUrl() . '" type="audio/mp3">';
                        echo 'Your browser does not support the audio element.';
                    echo '</audio>';
                echo '</div>';
            }

            
            $db->close();
        ?>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
