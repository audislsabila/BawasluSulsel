<?php
session_start();
require 'function.php'; // Pastikan file ini berisi koneksi database yang benar

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Gunakan prepared statement untuk keamanan
    $stmt = $conn->prepare("SELECT * FROM login WHERE email = ? AND role = 'user'");
    if (!$stmt) {
        die("Error in prepare statement: " . $conn->error); 
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verifikasi password dengan password_verify
        if (password_verify($password, $user['password'])) {
            $_SESSION['log'] = 'true';
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $user['email'];

            // Redirect ke halaman user
            header("location: user_dashboard.php");
            exit();
        } else {
            header("location: login.php"); // Password salah
            exit();
        }
    } else {
        header("location: login.php"); // Email tidak ditemukan atau bukan user
        exit();
    }
}
?>
