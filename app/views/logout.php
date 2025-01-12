<?php
class SessionManager
{
    public function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function destroySession()
    {
        // Start session if not already started
        $this->startSession();

        // Unset all session variables
        $_SESSION = [];

        // Destroy the session
        session_destroy();
    }

    public function redirectToLogin()
    {
        header("Location: login.html");
        exit();
    }
}

// Create an instance of SessionManager
$sessionManager = new SessionManager();

// Perform logout
$sessionManager->destroySession();
$sessionManager->redirectToLogin();
?>
