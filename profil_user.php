<?php 
require 'function.php';
require 'cek.php';

// Cek apakah user sudah login
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Cek role user
$isAdmin = ($_SESSION['role'] == 'admin');
if($isAdmin) {
    header('Location: profile_setting.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="icon" type="image/jpeg" href="image/logo-bawaslu-provinsi.jpeg">
        <title>Profile Setting - BAWASLU</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <style>
            .profile-img {
                width: 150px;
                height: 150px;
                object-fit: cover;
                border-radius: 50%;
                border: 5px solid #eee;
            }
            .profile-img-container {
                text-align: center;
                margin-bottom: 20px;
            }
            .file-upload {
                display: none;
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand d-flex align-items-center" href="index.html">
            <img src="image/logo-bawaslu-provinsi.jpeg" height="30" class="mr-2" alt="Logo Bawaslu">
            <span>DIVISI BAWASLU</span>
        </a>
        
        <!-- Hamburger Button -->
            <button class="btn btn-link btn-sm order-0 order-lg-0 mr-2" id="sidebarToggle" href="#">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <div class="d-flex align-items-center">
                        <!-- Teks Nama Pengguna -->
                        <span class="text-white mr-2"><?= $_SESSION['email'] ?></span>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="profil_user.php">Setting</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>  
    <!-- Layout -->
    <div id="layoutSidenav">
        <!-- Sidebar -->
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <!-- Core Menu -->
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="Dahboard_user.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        
                        <!-- Surat Menu -->
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" 
                           data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Surat
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" 
                             data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link" href="surat_user.php">Surat Masuk Dan Keluar</a>
                            </nav>
                        </div>
                        
                        <a class="nav-link" href="administrasi_user.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-archive"></i></div>
                            Administrasi 
                        </a>
                        
                        <!-- Addons Menu -->
                        <div class="sb-sidenav-menu-heading">Addons</div>
                        
                        <!-- Agenda Rapat -->
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" 
                           data-target="#collapseAgenda" aria-expanded="false" aria-controls="collapseAgenda">
                            <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                            Agenda rapat
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseAgenda" aria-labelledby="headingTwo" 
                             data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link" href="agenda_rapat_user.php">agenda</a>
                            </nav>
                        </div>
                        
                        <a class="nav-link" href="pelatihan_kegiatan_user.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Pelatihan Kegiatan Rapat
                        </a>
                        
                        <a class="nav-link" href="kehadiran_user.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-list-alt"></i></div>
                            Laporan Kehadiran
                        </a>
                    </div>
                </div>
            </nav>
        </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Profile Setting</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="Dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profile Setting</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-user-edit mr-1"></i>
                                Edit Your Profile
                            </div>
                            <div class="card-body">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="profile-img-container">
                                                <img src="uploads/profil/<?= htmlspecialchars($user['foto'] ?? 'default.jpg') ?>" 
                                                     class="profile-img" id="profile-preview">
                                                <div class="mt-3">
                                                    <input type="file" name="foto" id="file-upload" class="file-upload" accept="image/*">
                                                    <label for="file-upload" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-upload"></i> Change Photo
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" 
                                                       value="<?= htmlspecialchars($currentUserEmail) ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama">Full Name</label>
                                                <input type="text" class="form-control" id="nama" name="nama" 
                                                       value="<?= htmlspecialchars($user['nama'] ?? $defaultValues['nama']) ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="jabatan">Position</label>
                                                <input type="text" class="form-control" id="jabatan" name="jabatan" 
                                                       value="<?= htmlspecialchars($user['jabatan'] ?? $defaultValues['jabatan']) ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="no_hp">Phone Number</label>
                                                <input type="text" class="form-control" id="no_hp" name="no_hp" 
                                                       value="<?= htmlspecialchars($user['no_hp'] ?? $defaultValues['no_hp']) ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="angkatan">Batch</label>
                                                <input type="text" class="form-control" id="angkatan" name="angkatan" 
                                                       value="<?= htmlspecialchars($user['angkatan'] ?? $defaultValues['angkatan']) ?>">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="alamat">Address</label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= 
                                            htmlspecialchars($user['alamat'] ?? $defaultValues['alamat']) ?></textarea>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="jenis_kelamin">Gender</label>
                                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                                    <option value="Laki-laki" <?= 
                                                        ($user['jenis_kelamin'] ?? $defaultValues['jenis_kelamin']) == 'Laki-laki' ? 'selected' : '' ?>>Male</option>
                                                    <option value="Perempuan" <?= 
                                                        ($user['jenis_kelamin'] ?? $defaultValues['jenis_kelamin']) == 'Perempuan' ? 'selected' : '' ?>>Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="agama">Religion</label>
                                                <select class="form-control" id="agama" name="agama">
                                                    <option value="Islam" <?= 
                                                        ($user['agama'] ?? $defaultValues['agama']) == 'Islam' ? 'selected' : '' ?>>Islam</option>
                                                    <option value="Kristen" <?= 
                                                        ($user['agama'] ?? $defaultValues['agama']) == 'Kristen' ? 'selected' : '' ?>>Christian</option>
                                                    <option value="Katolik" <?= 
                                                        ($user['agama'] ?? $defaultValues['agama']) == 'Katolik' ? 'selected' : '' ?>>Catholic</option>
                                                    <option value="Hindu" <?= 
                                                        ($user['agama'] ?? $defaultValues['agama']) == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                                                    <option value="Buddha" <?= 
                                                        ($user['agama'] ?? $defaultValues['agama']) == 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                                                    <option value="Konghucu" <?= 
                                                        ($user['agama'] ?? $defaultValues['agama']) == 'Konghucu' ? 'selected' : '' ?>>Confucianism</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <button type="submit" name="update" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Profile
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; BAWASLU <?= date('Y') ?></div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script>
            // Preview image before upload
            document.getElementById('file-upload').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('profile-preview').src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
    </body>
</html>