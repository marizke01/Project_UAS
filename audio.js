const addMusicForm = document.getElementById('addMusicForm');
const playlistItems = document.getElementById('playlistItems');
const currentMusic = document.getElementById('currentMusic');
const playBtn = document.getElementById('playBtn');
const pauseBtn = document.getElementById('pauseBtn');
const stopBtn = document.getElementById('stopBtn');

let playlist = [];
let currentPlayingIndex = null;

// Tambahkan musik ke playlist
addMusicForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const musicTitle = document.getElementById('musicTitle').value.trim();
    if (musicTitle) {
        playlist.push(musicTitle);
        updatePlaylist();
        document.getElementById('musicTitle').value = '';
    }
});

// Perbarui tampilan playlist
function updatePlaylist() {
    playlistItems.innerHTML = '';
    playlist.forEach((music, index) => {
        const li = document.createElement('li');
        li.textContent = music;
        li.addEventListener('click', () => playMusic(index));
        playlistItems.appendChild(li);
    });
}

// Putar musik
function playMusic(index) {
    currentPlayingIndex = index;
    currentMusic.textContent = `Memutar: ${playlist[index]}`;
}

// Kontrol pemutar musik
playBtn.addEventListener('click', () => {
    if (currentPlayingIndex !== null) {
        alert(`Memutar: ${playlist[currentPlayingIndex]}`);
    } else {
        alert('Pilih musik terlebih dahulu.');
    }
});

pauseBtn.addEventListener('click', () => {
    if (currentPlayingIndex !== null) {
        alert(`Pause: ${playlist[currentPlayingIndex]}`);
    }
});

stopBtn.addEventListener('click', () => {
    currentPlayingIndex = null;
    currentMusic.textContent = 'Tidak ada musik yang diputar';
});
