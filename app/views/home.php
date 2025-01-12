<?php

class Page {
    public function renderHeader($title) {
        echo "<head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>$title</title>
            <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'>
            <link rel='stylesheet' href='styles.css'>
            <style>
                body {
                    background-color:rgb(54, 2, 47);
                    font-family: 'Arial', sans-serif;
                }
                .navbar {
                    background-color: #343a40;
                }
                .navbar-brand,
                .nav-link {
                    color: white !important;
                }
                .music-card {
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                }
                .music-card:hover {
                    transform: translateY(-10px);
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                }
                .music-card img {
                    height: 200px;
                    object-fit: cover;
                    border-radius: 5px;
                }
                .music-card .card-body {
                    padding: 20px;
                }
                .music-card .card-title {
                    font-size: 1.2rem;
                    font-weight: bold;
                    color: #343a40;
                }
                .music-card .card-text {
                    color: #6c757d;
                    font-size: 0.9rem;
                }
                .footer {
                    margin-top: 50px;
                    background-color: #343a40;
                    color: white;
                    text-align: center;
                    padding: 15px 0;
                }
                .footer a {
                    color: #fff;
                    text-decoration: none;
                    margin-left: 15px;
                }
                .footer a:hover {
                    text-decoration: underline;
                }
            </style>
        </head>";
    }

    public function renderNavbar() {
        echo "<nav class='navbar navbar-expand-lg navbar-dark'>
            <div class='container'>
                <a class='navbar-brand' href='#'>MEGA MUSIC</a>
                <div class='d-flex gap-2'>
                    <a href='search.php' class='nav-link'>Search</a>
                    <a href='premium.php' class='nav-link'>Premium</a>
                    <a href='collections.php' class='nav-link'>Collections</a>
                    <a href='akun.php' class='nav-link'>Account</a>
                    <a href='logout.php' class='nav-link'>Logout</a>
                </div>
            </div>
        </nav>";
    }

    public function renderFooter() {
        echo "<div class='footer'>
            <p>&copy; 2024 MusicApp. All Rights Reserved. | <a href='#'>Privacy Policy</a> | <a href='#'>Terms of Service</a></p>
        </div>";
    }

    public function renderMusicCards($musicCards) {
        echo "<div class='row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4'>";
        foreach ($musicCards as $card) {
            echo "<div class='col'>
                <a href='music_title.php?genre={$card['genre']}' style='text-decoration: none'>
                    <div class='card music-card'>
                        <img src='{$card['image']}' class='card-img-top' alt='Music Cover'>
                        <div class='card-body'>
                            <h5 class='card-title'>{$card['title']}</h5>
                            <p class='card-text'>{$card['description']}</p>
                        </div>
                    </div>
                </a>
            </div>";
        }
        echo "</div>";
    }
}

$page = new Page();
$musicCards = [
    ["genre" => "islam", "image" => "https://muhammadiyah.or.id/wp-content/uploads/2022/04/IMG-20220423-WA0018.jpg", "title" => "Qur'an", "description" => "Click to explore islamic audio!"],
    ["genre" => "rnb", "image" => "https://hips.hearstapps.com/esq.h-cdn.co/assets/16/38/1474476352-screen-shot-2016-09-21-at-124519-pm.png?resize=640:*", "title" => "Music R&B", "description" => "Click to explore popular R&B songs!"],
    ["genre" => "pop", "image" => "https://yt3.googleusercontent.com/DYQ0N2wtSvPGvyyulQkrK7rT7M4dVe4CESmYywX94n-W3dSFpgVCnVVqj5DLfJMfbgRPOB6ggw=s900-c-k-c0x00ffffff-no-rj", "title" => "Music Pop", "description" => "Click to explore popular pop songs!"],
    ["genre" => "jazz", "image" => "https://cdn.venngage.com/template/thumbnail/small/fb2a04b9-7536-432e-971b-2aed6aa6ec76.webp", "title" => "Music Jazz", "description" => "Click to explore popular jazz songs!"]
   
];

?>
<!DOCTYPE html>
<html lang="en">
<?php $page->renderHeader('Home - MusicApp'); ?>
<body class="d-flex flex-column min-vh-100 justify-content-between">
    <?php $page->renderNavbar(); ?>

    <div class="container mt-5">
    <h2 class="text-center mb-4 text-white">Welcome to MEGA MUSIC</h2>
    <?php $page->renderMusicCards($musicCards); ?>
</div>

    <?php $page->renderFooter(); ?>
</body>
</html>
