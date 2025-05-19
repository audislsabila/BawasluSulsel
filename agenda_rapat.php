<?php 
require 'function.php';
require 'cek.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>ADMINISTRASI DIVISI - Dashboard</title>
    <link rel="icon" type="image/jpeg" href="image/logo-bawaslu-provinsi.jpeg">
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        .badge-success { background-color: #28a745; color: white; }
        .badge-warning { background-color: #ffc107; color: black; }
        .badge-info { background-color: #17a2b8; color: white; }
        .badge-danger { background-color: #dc3545; color: white; }
        .file-info {
            font-size: 0.9rem;
            margin-top: 5px;
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
                    <a class="dropdown-item" href="profile_setting.php">Setting</a>
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
                        <a class="nav-link" href="Dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Laporan Bulanan
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="tahun.php">Bulan</a>
                            </nav>
                        </div>
                        <a class="nav-link" href="Administrasi.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-archive"></i></div>
                            Administrasi
                        </a>
                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="statistik_laporan.php">
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
                                <a class="nav-link" href="agenda_rapat.php">agenda</a>
                            </nav>
                        </div>
                        <a class="nav-link" href="Basis_data.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                            Basis Data Anggota
                        </a>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i> </i></div>
                            Pengaturan User
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link" href="pengaturan_user.php">Admin/User</a>
                            </nav>
                    </div>
                    <a class="nav-link" href="academic_holidays.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                                Libur kantor
                            </a>
                    </div>
                </div>
            </nav>
        </div>
    
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">AGENDA RAPAT</h1>
                <ol class="breadcrumb mb-4"></ol>

                <!-- Tambah Agenda Button -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">
                    Tambah Agenda Rapat
                </button>

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
                                    $ambilsemuadataagenda = mysqli_query($conn, "SELECT * FROM agenda_rapat");
                                    while ($data = mysqli_fetch_array($ambilsemuadataagenda)) {
                                        $id_rapat = $data['id_rapat'];
                                        $judul = $data['judul_rapat'];
                                        $tanggal = $data['tanggal'];
                                        $waktu_mulai = $data['waktu_mulai'];
                                        $waktu_selesai = $data['waktu_selesai'];
                                        $tempat = $data['tempat'];
                                        $status = $data['status'];
                                        $pimpinan = $data['pemimpinan_rapat'];
                                        $notulen = $data['notulen'];
                                        $peserta = $data['peserta'];
                                        $agenda = $data['agenda'];
                                        $dokumen_path = $data['dokumen_path'];
                                    ?> 
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $judul; ?></td>
                                        <td><?= date('d M Y', strtotime($tanggal)); ?></td>
                                        <td><?= date('H:i', strtotime($waktu_mulai)) . ' - ' . date('H:i', strtotime($waktu_selesai)); ?></td>
                                        <td><?= $tempat; ?></td>
                                        <td>
                                        <span class="badge badge-<?= 
                                                ($status == 'Terlaksana') ? 'success' : 
                                                (($status == 'Berlangsung') ? 'warning' : 
                                                (($status == 'Selesai') ? 'info' : 'danger')) 
                                            ?>">
                                                <?= $status; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detail<?= $id_rapat; ?>">
                                                Detail
                                            </button>
                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit<?= $id_rapat; ?>">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete<?= $id_rapat; ?>">
                                                Hapus
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
                                                            <?= $pimpinan; ?>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <strong>Notulen:</strong>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <?= $notulen; ?>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <strong>Peserta:</strong>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="border p-2">
                                                                <?= nl2br($peserta); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <strong>Agenda:</strong>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="border p-2">
                                                                <?= nl2br($agenda); ?>
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
                                                        <?php if($dokumen_path != '' && file_exists($dokumen_path)): ?>
                                                            <a href="<?= $dokumen_path; ?>" target="_blank" class="btn btn-sm btn-info mr-2">
                                                                <i class="fas fa-eye"></i> Lihat Dokumen
                                                            </a>
                                                            <a href="download.php?file=<?= urlencode($dokumen_path) ?>" class="btn btn-sm btn-success">
                                                                <i class="fas fa-file-download"></i> Download
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
                                 <!-- Edit Modal -->
                                    <div class="modal fade" id="edit<?=$id_rapat;?>">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form method="post" enctype="multipart/form-data">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Agenda Rapat</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id_rapat" value="<?=$id_rapat;?>">
                                                        <input type="hidden" name="existing_file" value="<?=$dokumen_path;?>">
                                                        
                                                        <div class="form-group">
                                                            <label>Judul Rapat</label>
                                                            <input type="text" name="judul" class="form-control" value="<?=$judul;?>" required>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Tanggal</label>
                                                                <input type="date" name="tanggal" class="form-control" value="<?=$tanggal;?>" required>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label>Waktu Mulai</label>
                                                                <input type="time" name="waktu_mulai" class="form-control" value="<?=$waktu_mulai;?>" required>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label>Waktu Selesai</label>
                                                                <input type="time" name="waktu_selesai" class="form-control" value="<?=$waktu_selesai;?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Tempat Rapat</label>
                                                            <input type="text" name="tempat" class="form-control" value="<?=$tempat;?>" required>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Pemimpin Rapat</label>
                                                                <input type="text" name="pimpinan" class="form-control" value="<?=$pimpinan;?>" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Notulen</label>
                                                                <input type="text" name="notulen" class="form-control" value="<?=$notulen;?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Peserta</label>
                                                            <textarea name="peserta" class="form-control" rows="3" required><?=$peserta;?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Agenda</label>
                                                            <textarea name="agenda" class="form-control" rows="3" required><?=$agenda;?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Status Rapat</label>
                                                            <select name="status" class="form-control" required>
                                                                <option value="Terlaksana" <?=($status == 'Terlaksana') ? 'selected' : '';?>>Terlaksana</option>
                                                                <option value="Berlangsung" <?=($status == 'Berlangsung') ? 'selected' : '';?>>Berlangsung</option>
                                                                <option value="Selesai" <?=($status == 'Selesai') ? 'selected' : '';?>>Selesai</option>
                                                                <option value="Dibatalkan" <?=($status == 'Dibatalkan') ? 'selected' : '';?>>Dibatalkan</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Dokumen Pendukung</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" name="dokumen" id="dokumen<?=$id_rapat;?>">
                                                                <label class="custom-file-label"><?=basename($dokumen_path);?></label>
                                                            </div>
                                                            <?php if($dokumen_path): ?>
                                                            <small class="form-text text-muted">
                                                                File saat ini: <a href="<?=$dokumen_path;?>" target="_blank"><?=basename($dokumen_path);?></a>
                                                                <div class="form-check mt-2">
                                                                    <input class="form-check-input" type="checkbox" name="hapus_file" id="hapus_file">
                                                                    <label class="form-check-label" for="hapus_file">
                                                                        Hapus file saat ini
                                                                    </label>
                                                                </div>
                                                            </small>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary" name="updaterapat">Simpan Perubahan</button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="delete<?= $id_rapat; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">Hapus Agenda</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id_rapat" value="<?= $id_rapat; ?>">
                                                        <p>Apakah Anda yakin ingin menghapus agenda rapat berikut?</p>
                                                        <ul>
                                                            <li>Judul: <strong><?= $judul; ?></strong></li>
                                                            <li>Tanggal: <?= date('d M Y', strtotime($tanggal)); ?></li>
                                                            <li>Tempat: <?= $tempat; ?></li>
                                                        </ul>
                                                        <div class="alert alert-warning">
                                                            <i class="fas fa-exclamation-triangle"></i> Data yang dihapus tidak dapat dikembalikan!
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger" name="HapusRapat">Hapus Permanen</button>
                                                    </div>
                                                </form>
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
    
    <!-- Tambah Modal -->
    <div class="modal fade" id="tambahModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Judul Rapat</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label>Waktu Mulai</label>
                                <input type="time" name="waktu_mulai" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label>Waktu Selesai</label>
                                <input type="time" name="waktu_selesai" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tempat</label>
                            <input type="text" name="tempat" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Pemimpin Rapat</label>
                                <input type="text" name="pimpinan" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Notulen</label>
                                <input type="text" name="notulen" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Peserta</label>
                            <textarea name="peserta" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Agenda</label>
                            <textarea name="agenda" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Terlaksana">Terlaksana</option>
                                <option value="Berlangsung">Berlangsung</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Dibatalkan">Dibatalkan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Dokumen Pendukung (PDF/DOC/DOCX)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="dokumen" id="dokumenTambah">
                                <label class="custom-file-label" for="dokumenTambah">Pilih file...</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" name="addrapat">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    
    <script>
    // Script untuk update nama file di semua modal
    $(document).ready(function() {
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
        
        // Inisialisasi DataTable
        $('#dataTable').DataTable();
    });
    </script>
</body>
</html>