<?php
class Database {
    private $host = "localhost";
    private $user = "root"; // Username database
    private $pass = "";     // Password database
    private $db   = "music_app";
    private $conn;

    // Constructor untuk membuat koneksi saat class diinisialisasi
    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);

        // Periksa koneksi
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Fungsi untuk menjalankan query
    public function query($sql) {
        $result = $this->conn->query($sql);

        // Periksa jika query gagal
        if (!$result) {
            die("Query error: " . $this->conn->error);
        }

        return $result;
    }

    // Fungsi untuk menutup koneksi (Opsional)
    public function close() {
        $this->conn->close();
    }

    // Getter untuk mendapatkan koneksi langsung (jika diperlukan)
    public function getConnection() {
        return $this->conn;
    }
}
?>
