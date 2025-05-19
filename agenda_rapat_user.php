<?php 
require 'function.php';
require 'cek.php';

// Di baris paling atas file
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/cek.php';  // Gunakan path absolut
// Cek role user
$isAdmin = ($_SESSION['role'] == 'admin');
if($isAdmin) {
    header('Location: agenda_rapat.php');
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
    <title>AGENDA RAPAT - User</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        .badge-success { background-color: #28a745; color: white; }
        .badge-warning { background-color: #ffc107; color: black; }
        .badge-info { background-color: #17a2b8; color: white; }
        .badge-danger { background-color: #dc3545; color: white; }
        .meeting-card {
            border-left: 4px solid #4e73df;
            margin-bottom: 15px;
        }
        .meeting-card:hover {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
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
                        <a class="nav-link" href="DashboardUser.php">
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
                                <a class="nav-link" href="Surat.php">Surat Masuk Dan Keluar</a>
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
                        
                        <a class="nav-link" href="Pelatihan_kegiatan_rapat.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Pelatihan Kegiatan Rapat
                        </a>
                        
                        <a class="nav-link" href="Kehadiran.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-list-alt"></i></div>
                            Laporan Kehadiran
                        </a>
                    </div>
                </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                    <?= isset($_SESSION['nama']) ? htmlspecialchars($_SESSION['nama']) : ''; ?>  
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">AGENDA RAPAT</h1>
                    <ol class="breadcrumb mb-4"></ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Daftar Agenda Rapat
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul Rapat</th>
                                            <th>Tanggal</th>
                                            <th>Waktu</th>
                                            <th>Tempat</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $ambilsemuadataagenda = mysqli_query($conn, "SELECT 
                                            id_rapat,
                                            judul_rapat,
                                            tanggal,
                                            waktu_mulai,
                                            waktu_selesai,
                                            tempat,
                                            pemimpinan_rapat,
                                            notulen,
                                            peserta,
                                            agenda,
                                            IFNULL(dokumen_path, '') AS dokumen_path,
                                            status 
                                        FROM agenda_rapat");
                                        
                                        while ($data = mysqli_fetch_array($ambilsemuadataagenda)) {
                                            $id_rapat = $data['id_rapat'];
                                            $judul = $data['judul_rapat'];
                                            $tanggal = $data['tanggal'];
                                            $waktu_mulai = $data['waktu_mulai'];
                                            $waktu_selesai = $data['waktu_selesai'];
                                            $tempat = $data['tempat'];
                                            $status = $data['status'];
                                            $dokumen_path = $data['dokumen_path'] ?? '';
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($judul); ?></td>
                                            <td><?= date('d M Y', strtotime($tanggal)); ?></td>
                                            <td><?= date('H:i', strtotime($waktu_mulai)) . ' - ' . date('H:i', strtotime($waktu_selesai)); ?></td>
                                            <td><?= htmlspecialchars($tempat); ?></td>
                                            <td>
                                                <span class="badge badge-<?= 
                                                    ($status == 'Terlaksana') ? 'success' : 
                                                    (($status == 'Ditunda') ? 'warning' : 'secondary') 
                                                ?>">
                                                    <?= htmlspecialchars($status); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detail<?= $id_rapat; ?>">
                                                    Detail
                                                </button>
                                            </td>
                                        </tr>
                                     <!-- Detail Modal -->
                                         <div class="modal fade" id="detail<?= $id_rapat; ?>">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title">Detail Agenda Rapat</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <strong>Judul Rapat:</strong>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <?= $judul; ?>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <strong>Tanggal:</strong>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <?= date('d F Y', strtotime($tanggal)); ?>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <strong>Waktu:</strong>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <?= date('H:i', strtotime($waktu_mulai)) . ' - ' . date('H:i', strtotime($waktu_selesai)) ?>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <strong>Tempat:</strong>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <?= $tempat; ?>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <strong>Pemimpin Rapat:</strong>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <?= $data['pemimpinan_rapat']; ?>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <strong>Notulen:</strong>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <?= $data['notulen']; ?>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <strong>Peserta:</strong>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="border p-2">
                                                                    <?= nl2br($data['peserta']); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <strong>Agenda:</strong>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="border p-2">
                                                                    <?= nl2br($data['agenda']); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <strong>Status:</strong>
                                                            </div>
                                                            <div class="col-md-8">
                                                            <span class="badge badge-<?= 
                                                                    ($status == 'Terlaksana') ? 'success' : 
                                                                    (($status == 'Berlangsung') ? 'warning' : 
                                                                    (($status == 'Selesai') ? 'info' : 'danger')) 
                                                                ?>">
                                                                    <?= $status; ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <strong>Dokumen:</strong>
                                                            </div>
                                                            <div class="col-md-8">
                                                            <?php if($data['dokumen_path'] != '' && file_exists($data['dokumen_path'])): ?>
                                                                <a href="download.php?file=<?= urlencode($data['dokumen_path']) ?>" class="btn btn-sm btn-info">
                                                                    <i class="fas fa-file-download"></i> Download Dokumen
                                                                </a>
                                                            <?php else: ?>
                                                                <span class="text-muted">Tidak ada dokumen</span>
                                                            <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json"
                }
            });
        });
    </script>
</body>
</html>