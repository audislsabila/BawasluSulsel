<?php
// install.php

$host = "localhost";
$user = "root";
$pass = "";
$db = "bawaslusulsel";

// Buat koneksi tanpa memilih database
$conn = mysqli_connect($host, $user, $pass);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Buat database
$sql = "CREATE DATABASE IF NOT EXISTS $db";
if (mysqli_query($conn, $sql)) {
    echo "Database berhasil dibuat atau sudah ada<br>";
} else {
    die("Error membuat database: " . mysqli_error($conn));
}

// Pilih database
mysqli_select_db($conn, $db);

// Buat tabel users
$sql = "CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (mysqli_query($conn, $sql)) {
    echo "Tabel users berhasil dibuat atau sudah ada<br>";
} else {
    die("Error membuat tabel: " . mysqli_error($conn));
}

// Tambahkan user admin default jika belum ada
$checkAdmin = mysqli_query($conn, "SELECT * FROM users WHERE email='admin@example.com'");
if (mysqli_num_rows($checkAdmin) == 0) {
    $sql = "INSERT INTO `users` (`nama`, `jabatan`, `no_hp`, `alamat`, `email`, `password`, `role`) 
            VALUES ('Admin', 'Administrator', '08123456789', 'Alamat admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin')";
    
    if (mysqli_query($conn, $sql)) {
        echo "User admin berhasil ditambahkan<br>";
        echo "Email: admin@example.com<br>";
        echo "Password: password<br>";
    } else {
        echo "Error menambahkan admin: " . mysqli_error($conn) . "<br>";
    }
} else {
    echo "User admin sudah ada<br>";
}

echo "Instalasi selesai. Silakan <a href='login.php'>login</a>.";
mysqli_close($conn);
?>