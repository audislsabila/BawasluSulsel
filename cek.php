<?php 
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
  
}


// Check if user is logged in
if(!isset($_SESSION['log'])) {
    header('location:Login.php');
    exit(); // Always exit after header redirect
}


// Update last activity
$id_user = $_SESSION['id_user'];
$currentTime = date('Y-m-d H:i:s');
mysqli_query($conn, "UPDATE online_users SET last_activity = '$currentTime' WHERE id_user = '$id_user'");

// Check if id_user exists in session
if (!isset($_SESSION['id_user'])) {
    header("Location: logout.php");
    exit(); // Always exit after header redirect
}
?>