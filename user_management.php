<?php
session_start();
require 'function.php';

if (!isset($_SESSION['log']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Tambah user
if (isset($_POST['tambah'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO login (email, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $password, $role);
    $stmt->execute();
    header("Location: user_management.php");
}

// Hapus user
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM login WHERE id_user = $id");
    header("Location: user_management.php");
}
?>

<h2>Manajemen Pengguna</h2>
<form method="post">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="text" name="password" placeholder="Password" required><br>
    <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select><br>
    <button name="tambah">Tambah</button>
</form>

<h3>Daftar User</h3>
<table border="1">
    <tr>
        <th>Email</th>
        <th>Role</th>
        <th>Aksi</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM login");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['email']}</td>
            <td>{$row['role']}</td>
            <td><a href='user_management.php?hapus={$row['id_user']}'>Hapus</a></td>
        </tr>";
    }
    ?>
</table>
