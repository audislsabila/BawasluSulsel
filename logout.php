<?php
session_start(); // Mulai session
// Catat aktivitas logout
error_log("User logout: ".($_SESSION['email'] ?? 'unknown')." - ".$_SERVER['REMOTE_ADDR']);

// Hapus semua data session
$_SESSION = array();

// Hapus cookie session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

if(isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    mysqli_query($conn, "UPDATE users SET last_activity = NULL WHERE id = $userId");
}

session_destroy();
session_unset();

// Redirect ke halaman login
header('location: Login.php');

?>