<?php
// 1. Initialize the session
session_start();

// 2. Unset all session variables
$_SESSION = array();

// 3. Destroy the session cookie in the browser
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Finally, destroy the session on the server
session_destroy();

// 5. Redirect to the login page
header("Location: login.php?msg=logged_out");
exit();
?>