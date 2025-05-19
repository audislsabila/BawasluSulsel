<?php
require 'function.php';
require 'cek.php';

// Dapatkan data user yang sedang login
$email = $_SESSION['email'];
$userData = getUserData($conn, $email);

if (!$userData) {
    die("Data user tidak ditemukan");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
        }
        .biodata-card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <li class="nav-item">
    <a class="nav-link" href="biodata.php">
        <i class="fas fa-user"></i> Biodata
    </a>
</li>
    
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card biodata-card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Biodata Pengguna</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <?php if (!empty($userData['foto'])): ?>
                                <img src="<?= $userData['foto'] ?>" alt="Foto Profil" class="profile-img">
                            <?php else: ?>
                                <img src="assets/img/default-profile.png" alt="Foto Profil" class="profile-img">
                            <?php endif; ?>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h5>Nama Lengkap</h5>
                                <p class="text-muted"><?= htmlspecialchars($userData['nama']) ?></p>
                            </div>
                            <div class="col-md-6">
                                <h5>Jabatan</h5>
                                <p class="text-muted"><?= htmlspecialchars($userData['jabatan']) ?></p>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h5>Email</h5>
                                <p class="text-muted"><?= htmlspecialchars($userData['email']) ?></p>
                            </div>
                            <div class="col-md-6">
                                <h5>Nomor HP</h5>
                                <p class="text-muted"><?= htmlspecialchars($userData['no_hp']) ?></p>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <h5>Alamat</h5>
                            <p class="text-muted"><?= nl2br(htmlspecialchars($userData['alamat'])) ?></p>
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="profile_setting.php" class="btn btn-primary">Edit Profil</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>