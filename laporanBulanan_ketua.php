<?php 
require 'function.php';
require 'cek.php';

// Cek role user
$isAdmin = ($_SESSION['role'] == 'admin');
if($isAdmin) {
    header('Location: tahun.php');
    exit;
}

function handleLaporanBulanan() {
    global $conn;
    
    // Konfigurasi Upload
    $max_size = 50 * 1024 * 1024; // 50MB
    $allowed_types = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
    $upload_dir = 'uploads/';
    
    // Buat folder upload jika belum ada
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // PROSES TAMBAH LAPORAN
    if(isset($_POST['addlaporanbulanan'])) {
        // Validasi ukuran server
        if ($_SERVER['CONTENT_LENGTH'] > $max_size) {
            $_SESSION['pesan'] = [
                'status' => 'error',
                'pesan' => 'Ukuran file terlalu besar (Maks 50MB)'
            ];
            return;
        }

        // Handle file upload
        $file_lampiran = '';
        if ($_FILES['file_lampiran']['error'] == UPLOAD_ERR_OK) {
            $file_name = $_FILES['file_lampiran']['name'];
            $file_tmp = $_FILES['file_lampiran']['tmp_name'];
            $file_size = $_FILES['file_lampiran']['size'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Validasi
            if (!in_array($file_ext, $allowed_types)) {
                $_SESSION['pesan'] = [
                    'status' => 'error',
                    'pesan' => 'Format file tidak didukung'
                ];
                return;
            }

            if ($file_size > $max_size) {
                $_SESSION['pesan'] = [
                    'status' => 'error',
                    'pesan' => 'Ukuran file melebihi batas 50MB'
                ];
                return;
            }

            // Generate nama unik
            $new_name = uniqid('laporan_', true) . '.' . $file_ext;
            $destination = $upload_dir . $new_name;

            if (move_uploaded_file($file_tmp, $destination)) {
                $file_lampiran = $new_name;
            } else {
                $_SESSION['pesan'] = [
                    'status' => 'error',
                    'pesan' => 'Gagal mengupload file'
                ];
                return;
            }
        }

        // Ambil data form
        $judul = mysqli_real_escape_string($conn, $_POST['judul']);
        $bulan = mysqli_real_escape_string($conn, $_POST['bulan']);
        $tahun = mysqli_real_escape_string($conn, $_POST['tahun']);
        $isi_laporan = mysqli_real_escape_string($conn, $_POST['isi_laporan']);
        $tanggal_upload = $_POST['tanggal_upload'];

        // Insert ke database
        $stmt = $conn->prepare("INSERT INTO laporan_bulanan 
            (judul, bulan, tahun, isi_laporan, file_lampiran, tanggal_upload) 
            VALUES (?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("ssssss", 
            $judul, 
            $bulan, 
            $tahun, 
            $isi_laporan, 
            $file_lampiran, 
            $tanggal_upload
        );

        if ($stmt->execute()) {
            $_SESSION['pesan'] = [
                'status' => 'success',
                'pesan' => 'Laporan berhasil ditambahkan'
            ];
        } else {
            $_SESSION['pesan'] = [
                'status' => 'error',
                'pesan' => 'Gagal menambahkan laporan: ' . $stmt->error
            ];
        }
        
        $stmt->close();
    }
    
    // PROSES UPDATE (Tambahkan jika diperlukan)
    // ...
}

// Panggil fungsi handle laporan
handleLaporanBulanan();
// Tambahkan dalam fungsi handleLaporanBulanan() di function.php

// PROSES UPDATE LAPORAN
if(isset($_POST['updatelaporanbulanan'])) {
    // Validasi ID
    if(!isset($_POST['id_laporan']) || !is_numeric($_POST['id_laporan'])) {
        $_SESSION['pesan'] = [
            'status' => 'error',
            'pesan' => 'ID laporan tidak valid'
        ];
        return;
    }

    $id = (int)$_POST['id_laporan'];
    $old_file = $_POST['old_file'];
    
    // Ambil data form
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $bulan = mysqli_real_escape_string($conn, $_POST['bulan']);
    $tahun = mysqli_real_escape_string($conn, $_POST['tahun']);
    $isi_laporan = mysqli_real_escape_string($conn, $_POST['isi_laporan']);
    $tanggal_upload = $_POST['tanggal_upload'];
    
    // Handle file upload
    $file_lampiran = $old_file; // Default ke file lama
    
    if($_FILES['file_lampiran']['error'] == UPLOAD_ERR_OK) {
        // Hapus file lama jika ada
        if(!empty($old_file) && file_exists($upload_dir.$old_file)) {
            unlink($upload_dir.$old_file);
        }

        // Proses upload file baru
        $file_name = $_FILES['file_lampiran']['name'];
        $file_tmp = $_FILES['file_lampiran']['tmp_name'];
        $file_size = $_FILES['file_lampiran']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Validasi
        if(!in_array($file_ext, $allowed_types)) {
            $_SESSION['pesan'] = [
                'status' => 'error',
                'pesan' => 'Format file tidak didukung'
            ];
            return;
        }

        if($file_size > $max_size) {
            $_SESSION['pesan'] = [
                'status' => 'error',
                'pesan' => 'Ukuran file melebihi batas 50MB'
            ];
            return;
        }

        // Generate nama unik
        $new_name = uniqid('laporan_', true).'.'.$file_ext;
        $destination = $upload_dir.$new_name;

        if(move_uploaded_file($file_tmp, $destination)) {
            $file_lampiran = $new_name;
        } else {
            $_SESSION['pesan'] = [
                'status' => 'error',
                'pesan' => 'Gagal mengupload file baru'
            ];
            return;
        }
    }

    // Update database
    $stmt = $conn->prepare("UPDATE laporan_bulanan SET 
        judul = ?,
        bulan = ?,
        tahun = ?,
        isi_laporan = ?,
        file_lampiran = ?,
        tanggal_upload = ?
        WHERE id_laporan = ?");
    
    $stmt->bind_param("ssssssi", 
        $judul,
        $bulan,
        $tahun,
        $isi_laporan,
        $file_lampiran,
        $tanggal_upload,
        $id
    );

    if($stmt->execute()) {
        $_SESSION['pesan'] = [
            'status' => 'success',
            'pesan' => 'Laporan berhasil diperbarui'
        ];
    } else {
        $_SESSION['pesan'] = [
            'status' => 'error',
            'pesan' => 'Gagal update: '.$stmt->error
        ];
    }
    
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="icon" type="image/jpeg" href="image/logo-bawaslu-provinsi.jpeg">
        <title>ADMINISTRASI DIVISI - Dashboard</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": false, // Menyembunyikan pagination
            "info": false,   // Menyembunyikan "Showing X to X of X entries"
            "lengthChange": false // Menyembunyikan "Show entries"
        });
    });
</script>
<!-- CSS Khusus untuk Print -->
<style>
    /* Tambahkan di dalam tag style di head atau di file CSS terpisah */
    #dataTable th {
        background-color: #ffffff !important;
        color: black !important;
        border-color: #dee2e6 !important;
    }
    
    #dataTable td {
        background-color: white !important;
        color: black !important;
        border-color: #dee2e6 !important;
    }
    
    #dataTable {
        background-color: white !important;
        border: 1px solid #dee2e6 !important;
    }
    
    /* Untuk header tabel */
    #dataTable thead th {
        background-color: #ffffff !important;
        border-bottom: 2px solid #dee2e6 !important;
    }
    
    /* Hover effect untuk row */
    #dataTable tr:hover td {
        background-color: #f8f9fa !important;
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
                        <a class="dropdown-item" href="profil_ketua.php">Setting</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>        
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="DashboardKetua.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Interface</div>
                            <a class="nav-link collapsed" href="laporanBulanan_ketua.php" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Laporan Bulanan
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="laporanBulanan_ketua.php">Bulan</a>
                                </nav>
                            </div>
                            <a class="nav-link" href="administrasi_ketua.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-archive"></i></div>
                                Administrasi
                            </a>
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="statistik_ketua.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Statistik Dan Laporan 
                            </a>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                                Agenda rapat
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link" href="agenda_ketua.php">agenda</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="no-print mt-4">Riwayat Aktivitas kegiatan Anggota Divisi</h1>
                        <ol class="breadcrumb mb-4">
                            <li class=" no-print breadcrumb-item active">Daftar Kegiatan Aktivitas Anggota Divisi Perbulan</li>
                        </ol>
                        <div class="card bg-secondary text-white mb-4">
                            <div class="card-body text-center">
                                <div class="table-responsive">
                                    <div class="print-only">
                                        <div class="header">
                                            <img src="https://3.bp.blogspot.com/-MYWK0OeoYfU/XJsBH5dmJ6I/AAAAAAAALYo/lLHintm61FANouhpNd6uzuqPs3PgapS2wCLcBGAs/s1600/logo-bawaslu%2BPersegi.png" width="200" alt="logo Bawaslu Provinsi Sulawesi Selatan">
                                            <h5>BAWASLU PROVINSI SULAWEI SELATAN </h5>
                                            <h6>BADAN PENGAWASAN PEMILIHAN UMUM</h6>
                                        </div>
                                        <div class="info">
                                            <p>Alamat : Jl. A. P. Pettarani No.98, Bua Kana, Kec. Rappocini, Kota Makassar, Sulawesi Selatan 90222</p>
                                        </div>
                                            <h3 class="text-center">RIWAYAT AKTIVITAS KEGIATAN DIVISI BAWASLU</h3>
                                    </div>
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                                <tr class="text-white">
                                                    <th>#</th>
                                                    <th>Judul</th>
                                                    <th>Bulan</th>
                                                    <th>Tahun</th>
                                                    <th>Isi Laporan</th>
                                                    <th>File Lampiran</th>
                                                    <th>Tanggal Upload</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                              $no= 1;
                                              $ambilsemuadatabulanan = mysqli_query($conn,"select * from laporan_bulanan");
                                              while($fetcharray = mysqli_fetch_array($ambilsemuadatabulanan)){
                                                $idL = $fetcharray['id_laporan'];
                                                $judul = $fetcharray['judul'];
                                                $bulan = $fetcharray['bulan'];
                                                $tahun = $fetcharray['tahun'];
                                                $isi_laporan = $fetcharray['isi_laporan'];
                                                $file_lampiran = $fetcharray['file_lampiran'];
                                                $tanggal_upload = $fetcharray['tanggal_upload'];
                                            ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $judul; ?></td>
                                                <td><?php echo $bulan; ?></td>
                                                <td><?php echo $tahun; ?></td>
                                                <td><?php echo $isi_laporan; ?></td>
                                                <td>
                                                    <?php if ($fetcharray['file_lampiran'] && file_exists('uploads/' . $fetcharray['file_lampiran'])): ?>
                                                        <a href="uploads/<?= $fetcharray['file_lampiran'] ?>" download class="btn btn-sm btn-success">
                                                            Download
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-danger">No File</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo $tanggal_upload; ?></td>
                                            </tr>
                                            <?php
                                              };
                                            ?>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
        <script>
             $(document).ready(function() {
             $('#dataTable').DataTable({
                "paging": false, 
                "info": false, 
                "lengthChange": false 
              });
            });
        </script>
    </body>
</html>
