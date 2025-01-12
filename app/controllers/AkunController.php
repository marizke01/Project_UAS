<?php

class AkunController {
    private $akun;

    public function __construct() {
        $this->akun = new Akun();
    }

    public function login($username, $password) {
        $user = $this->akun->getUser($username, $password);
        if ($user) {
            $_SESSION['username'] = $username;
            header("Location: /home.php");
        } else {
            echo "Invalid credentials.";
        }
    }

    public function register($username, $password) {
        $this->akun->createUser($username, $password);
        header("Location: /login.php");
    }

    public function logout() {
        session_destroy();
        header("Location: /login.php");
    }
}
