<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// if log out button is pressed, this whole controller is called
if (isset($_SESSION['user_data'])) {
    // Clear the session array
    $_SESSION = array();

    //
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, //deletes all cookies from the session
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destroy the session
    session_destroy(); //unsets and destroys the session
}

// Redirect to the login page
header("Location: index.php");
exit();

