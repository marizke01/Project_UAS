<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Musiq - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="top-bar">
        <div class="logo">
            <img src="logo.png" alt="MusicHub Logo">
        </div>
        <div class="menu">
            <input type="text" placeholder="Apa yang ingin kamu putar?">
            <button class="btn-login">Masuk</button>
            <button class="btn-register">Daftar</button>
        </div>
    </header>

    <div class="main-content">
        <aside class="sidebar">
            <p class="sidebar-item">Koleksi Kamu</p>
            <div class="sidebar-card">
                <h3>Ayo cari beberapa podcast untuk diikuti</h3>
                <p>Kami akan terus mengabarimu tentang episode baru.</p>
                <button class="btn-podcast">Jelajahi podcast</button>
            </div>
        </aside>

        <main class="content">
            <section class="popular-artists">
                <h2>Artis Populer</h2>
                <div class="artist-grid">
                    <div class="artist">
                        <img src="artist1.jpg" alt="Bernadya">
                        <p>Bernadya</p>
                    </div>
                    <div class="artist">
                        <img src="artist2.jpg" alt="Mahalini">
                        <p>Mahalini</p>
                    </div>
                    <div class="artist">
                        <img src="artist3.jpg" alt="Juicy Luicy">
                        <p>Juicy Luicy</p>
                    </div>
                    <div class="artist">
                        <img src="artist4.jpg" alt="Tulus">
                        <p>Tulus</p>
                    </div>
                    <div class="artist">
                        <img src="artist5.jpg" alt="Adele">
                        <p>Adele</p>
                    </div>
                </div>
            </section>

            <section class="popular-albums">
                <h2>Album dan Single Populer</h2>
                <div class="album-grid">
                    <img src="album1.jpg" alt="Album 1">
                    <img src="album2.jpg" alt="Album 2">
                    <img src="album3.jpg" alt="Album 3">
                    <img src="album4.jpg" alt="Album 4">
                    <img src="album5.jpg" alt="album 5">
                </div>
            </section>
        </main>
    </div>

    <footer class="footer">
        <p>© 2024 MusicHub. All rights reserved.</p>
        <a href="#">Bahasa Indonesia</a>
    </footer>
</body>
</html>
