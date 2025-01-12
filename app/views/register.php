<?php
include 'db.php';

// Kelas untuk menangani koneksi database
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

// Kelas untuk menangani data pengguna
class User {
    private $username;
    private $password;
    private $profilePic;

    public function __construct($username, $password, $profilePic = null) {
        $this->username = $username;
        $this->password = $password;
        $this->profilePic = $profilePic;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getProfilePic() {
        return $this->profilePic;
    }

    public function save(Database $db) {
        $conn = $db->getConnection();
        $sql = "INSERT INTO users (username, password, profile_pic) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $this->username, $this->password, $this->profilePic);
        return $stmt->execute();
    }
}

// Kelas untuk menangani pengunggahan file
class FileUpload {
    private $file;
    private $uploadDir;

    public function __construct($file, $uploadDir = './uploads/') {
        $this->file = $file;
        $this->uploadDir = $uploadDir;
    }

    public function upload() {
        if ($this->file['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $this->file['tmp_name'];
            $fileName = $this->file['name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($fileExtension, $allowedExtensions)) {
                $newFileName = uniqid() . '.' . $fileExtension;
                $destPath = $this->uploadDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    return $newFileName;
                } else {
                    throw new Exception("Error moving the uploaded file.");
                }
            } else {
                throw new Exception("Upload failed. Allowed file types: " . implode(', ', $allowedExtensions));
            }
        } else {
            throw new Exception("File upload error.");
        }
    }
}

// Kelas untuk menangani logika pendaftaran
class Registration {
    private $db;
    private $user;
    private $fileUpload;

    public function __construct(Database $db, User $user, FileUpload $fileUpload) {
        $this->db = $db;
        $this->user = $user;
        $this->fileUpload = $fileUpload;
    }

    public function register() {
        try {
            // Validasi dan upload file profil jika ada
            if (isset($this->fileUpload)) {
                $profilePic = $this->fileUpload->upload();
                $this->user = new User($this->user->getUsername(), $this->user->getPassword(), $profilePic);
            }

            // Simpan data pengguna ke database
            if ($this->user->save($this->db)) {
                echo "<script>alert('Registration successful!'); window.location.href='login.html';</script>";
            } else {
                throw new Exception("Error saving user to database.");
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

// Proses pendaftaran
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        // Buat objek Database, User, dan FileUpload
        $db = new Database($conn);
        $user = new User($username, $password);
        
        // Pastikan folder uploads/ ada
        $uploadFileDir = './uploads/';
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }

        // Periksa apakah file profile_pic ada
        if (isset($_FILES['profile_pic'])) {
            $fileUpload = new FileUpload($_FILES['profile_pic'], $uploadFileDir);
            $registration = new Registration($db, $user, $fileUpload);
        } else {
            $registration = new Registration($db, $user, null);
        }

        // Jalankan pendaftaran
        $registration->register();

        // Tutup koneksi database
        $db->close();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>
