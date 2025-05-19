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
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        .status-rencana { background-color: #fff3cd; color: #856404; }
        .status-berlangsung { background-color: #cce5ff; color: #004085; }
        .status-selesai { background-color: #d4edda; color: #155724; }
        .status-dibatalkan { background-color: #f8d7da; color: #721c24; }
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
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link" href="Surat.php">Surat Masuk Dan Keluar</a>
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
                        </div>
                    </div>
                </nav>
            </div>
        
        <div id="layoutSidenav_content">
            <main>
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
                                        $ambildata = mysqli_query($conn, "SELECT * FROM agenda_rapat");
                                        while ($data = mysqli_fetch_array($ambildata)) {
                                            $id_rapat = $data['id_rapat'];
                                            $judul = $data['judul_rapat'];
                                            $tanggal = $data['tanggal'];
                                            $waktu_mulai = $data['waktu_mulai'];
                                            $waktu_selesai = $data['waktu_selesai'];
                                            $tempat = $data['tempat'];
                                            $status = $data['status'];
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
                                                    (($status == 'Ditunda') ? 'warning' : 'secondary') 
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
                                            <!-- Modal content with all meeting details -->
                                        </div>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="edit<?= $id_rapat; ?>">
                                            <!-- Similar structure to add modal but with existing data -->
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="delete<?= $id_rapat; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id_rapat" value="<?= $id_rapat; ?>">
                                                            Apakah yakin ingin menghapus agenda "<?= $judul; ?>"?
                                                            <br><br>
                                                            <button type="submit" class="btn btn-danger" name="HapusRapat">Hapus</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
</body>
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
                                    <option value="Ditunda">Ditunda</option>
                                    <option value="Dibatalkan">Dibatalkan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Dokumen Pendukung (PDF/DOC/DOCX)</label>
                                <input type="file" name="dokumen" class="form-control-file">
                            </div>
                            <button type="submit" class="btn btn-primary" name="addrapat">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</html>
