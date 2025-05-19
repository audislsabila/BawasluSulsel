<?php
require 'function.php';
require 'cek.php';

// Pastikan hanya user yang bisa akses
if($_SESSION['role'] != 'user') {
    header('location:Surat.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Download Surat</title>
    <!-- Sederhanakan tampilan untuk user -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Download Surat</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Surat</th>
                    <th>Tanggal</th>
                    <th>File</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($conn, "SELECT * FROM surat");
                while($data = mysqli_fetch_array($query)){
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $data['jenis_surat']; ?></td>
                    <td><?= $data['tanggal']; ?></td>
                    <td><a href="<?= $data['file_path']; ?>" download class="btn btn-success">Download</a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>