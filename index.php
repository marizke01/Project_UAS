<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>MusicHub</title>
</head>
<body>
    <div class="top-bar">
        <input type="text" id="searchMusic" placeholder="Cari musik...">
        <div>
        <button class="btn-login" onclick="window.location.href='login.php'">Masuk</button>
        <button class="btn-register" onclick="window.location.href='register.php'">Daftar</button>
        </div>
    </div>
    
    <div class="content">
        <h1>MusicHub</h1>
        <div class="music-controls">
            <form id="addMusicForm">
                <input type="text" id="musicTitle" placeholder="Judul musik">
                <button type="submit">Tambah ke Playlist</button>
            </form>
            <div id="playlist">
                <h2>Daftar Putar</h2>
                <ul id="playlistItems"></ul>
            </div>
        </div>
        <div class="music-player">
            <div class="player-info">
                <span id="currentMusic">Tidak ada musik yang diputar</span>
            </div>
            <div class="player-controls">
                <button id="playBtn">▶</button>
                <button id="pauseBtn">⏸</button>
                <button id="stopBtn">⏹</button>
            </div>
        </div>
    </div>
    <footer class="footer">© 2024 MusicHub. All rights reserved.</footer>
    <script src="script.js"></script>
</body>
</html>
