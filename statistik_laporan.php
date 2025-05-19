<?php 
require 'function.php';
require 'cek.php';

// Add Statistik
if(isset($_POST['addstatistik'])){
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $divisi = mysqli_real_escape_string($conn, $_POST['divisi']);
    $bulan = mysqli_real_escape_string($conn, $_POST['bulan']);
    $tahun = mysqli_real_escape_string($conn, $_POST['tahun']);
    $jumlah = mysqli_real_escape_string($conn, $_POST['jumlah']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    
    $query = "INSERT INTO statistik (nama_kegiatan, divisi, bulan, tahun, jumlah, status, tanggal) 
              VALUES ('$nama', '$divisi', '$bulan', '$tahun', '$jumlah', '$status', '$tanggal')";
    
    if(mysqli_query($conn, $query)){
        header("location:statistik_laporan.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
// Update Statistik
if(isset($_POST['updatestatistik'])){
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $divisi = $_POST['divisi'];
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
    $jumlah = $_POST['jumlah'];
    $status = $_POST['status'];
    $tanggal = $_POST['tanggal'];
    
    $query = "UPDATE statistik SET 
              nama_kegiatan = '$nama',
              divisi = '$divisi',
              bulan = '$bulan',
              tahun = '$tahun',
              jumlah = '$jumlah',
              status = '$status',
              tanggal = '$tanggal'
              WHERE id_statistik = '$id'";
    mysqli_query($conn, $query);
}

// Delete Statistik
if(isset($_POST['hapusstatistik'])){
    $id = $_POST['id'];
    $query = "DELETE FROM statistik WHERE id_statistik = '$id'";
    mysqli_query($conn, $query);
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
        <title>STATISTIK DIVISI - Dashboard</title>
        <link rel="icon" type="image/jpeg" href="image/logo-bawaslu-provinsi.jpeg">
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <style>
            /* ... (keep the same styles as previous) ... */
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
                    </div>
                </li>
                <!-- Notifikasi -->
                <li class="nav-item dropdown ml-2">
                    <a class="nav-link dropdown-toggle" id="notificationDropdown" href="#" role="button" 
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        <?php if (!empty($_SESSION['unread_notifications'])): ?>
                            <span class="badge badge-danger"><?= count($_SESSION['unread_notifications']) ?></span>
                        <?php endif; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-notifications" 
                        aria-labelledby="notificationDropdown">
                        <h6 class="dropdown-header">Notifikasi</h6>
                        <?php if (!empty($_SESSION['unread_notifications'])): ?>
                            <?php foreach ($_SESSION['unread_notifications'] as $notif): ?>
                                <a class="dropdown-item notification-item" href="<?= $notif['link'] ?>" 
                                data-id="<?= $notif['id'] ?>">
                                    <div class="notification-content">
                                        <div class="notification-text"><?= $notif['message'] ?></div>
                                        <div class="notification-time small text-muted">
                                            <?= timeAgo($notif['created_at']) ?>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <a class="dropdown-item text-center">Tidak ada notifikasi baru</a>
                        <?php endif; ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-center" href="all_notifications.php">Lihat Semua</a>
                    </div>
                </li>
                <!-- User Dropdown -->
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
                        <h1 class="mt-4">STATISTIK KEGIATAN</h1>
                        <ol class="breadcrumb mb-4"></ol>
                        
                        <div class="no-print">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Tambah Statistik
                            </button>
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Kegiatan</th>
                                                <th>Divisi</th>
                                                <th>Bulan</th>
                                                <th>Tahun</th>
                                                <th>Jumlah</th>
                                                <th>Status</th>
                                                <th>Tanggal</th>
                                                <th class="aksi-column">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $no = 1;
                                        $ambildata = mysqli_query($conn, "SELECT * FROM statistik");
                                        while($fetch = mysqli_fetch_array($ambildata)){
                                            $idS = $fetch['id_statistik'];
                                            $nama = $fetch['nama_kegiatan'];
                                            $divisi = $fetch['divisi'];
                                            $bulan = $fetch['bulan'];
                                            $tahun = $fetch['tahun'];
                                            $jumlah = $fetch['jumlah'];
                                            $status = $fetch['status'];
                                            $tanggal = $fetch['tanggal'];
                                        ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $nama; ?></td>
                                                <td><?= ucfirst($divisi); ?></td>
                                                <td><?= $bulan; ?></td>
                                                <td><?= $tahun; ?></td>
                                                <td><?= $jumlah; ?></td>
                                                <td><?= $status; ?></td>
                                                <td><?= date('d/m/Y', strtotime($tanggal)); ?></td>
                                                <td>
                                                    <button class="btn btn-warning" data-toggle="modal" data-target="#edit<?= $idS; ?>">
                                                        Edit
                                                    </button>
                                                    <button class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $idS; ?>">
                                                        Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                            
                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?= $idS; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="post">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Statistik</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id" value="<?= $idS; ?>">
                                                                
                                                                <div class="form-group">
                                                                    <label>Nama Kegiatan</label>
                                                                    <input type="text" name="nama" class="form-control" value="<?= $nama; ?>" required>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label>Divisi</label>
                                                                    <select name="divisi" class="form-control">
                                                                        <?php
                                                                        $options = ['sekretariat', 'administrasi', 'pppsp', 'peng...'];
                                                                        foreach($options as $option){
                                                                            $selected = ($divisi == $option) ? 'selected' : '';
                                                                            echo "<option value='$option' $selected>".ucfirst($option)."</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label>Bulan</label>
                                                                    <select name="bulan" class="form-control">
                                                                        <?php
                                                                        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                                                                 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                                                        foreach($months as $m){
                                                                            $selected = ($bulan == $m) ? 'selected' : '';
                                                                            echo "<option value='$m' $selected>$m</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label>Tahun</label>
                                                                    <input type="number" name="tahun" class="form-control" min="2000" max="2099" value="<?= $tahun; ?>" required>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label>Jumlah</label>
                                                                    <input type="number" name="jumlah" class="form-control" value="<?= $jumlah; ?>" required>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label>Status</label>
                                                                    <select name="status" class="form-control">
                                                                        <option value="Belum Berlangsung" <?= ($status == 'Belum Berlangsung') ? 'selected' : ''; ?>>Belum Berlangsung</option>
                                                                        <option value="Sedang Berjalan" <?= ($status == 'Sedang Berjalan') ? 'selected' : ''; ?>>Sedang Berjalan</option>
                                                                        <option value="Selesai" <?= ($status == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                                                                    </select>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label>Tanggal</label>
                                                                    <input type="date" name="tanggal" class="form-control" value="<?= $tanggal; ?>" required>
                                                                </div>
                                                                
                                                                <button type="submit" class="btn btn-primary" name="updatestatistik">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="delete<?= $idS; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Kegiatan Rapat</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus kegiatan rapat <strong><?=$idS;?></strong>?
                                                                <input type="hidden" name="id" value="<?=$idS;?>">                                                                <br><br>
                                                                <button type="submit" class="btn btn-danger" name="hapusstatistik">Hapus</button>
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
        </div>

        <!-- Add Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Statistik</h5>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama Kegiatan</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Divisi</label>
                                <select name="divisi" class="form-control" required>
                                    <option value="sekretariat">Sekretariat</option>
                                    <option value="administrasi">Administrasi</option>
                                    <option value="pppsp">Pppsp</option>
                                    <option value="pengawasan">Pengawasan</option>
                                    <option value="hukum">Hukum</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Bulan</label>
                                <select name="bulan" class="form-control" required>
                                    <?php
                                    $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                             'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                    foreach($months as $m){
                                        echo "<option value='$m'>$m</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Tahun</label>
                                <input type="number" name="tahun" class="form-control" min="2000" max="2099" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Jumlah</label>
                                <input type="number" name="jumlah" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="Belum Berlangsung">Belum Berlangsung</option>
                                    <option value="Sedang Berjalan">Sedang Berjalan</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary" name="addstatistik">Simpan</button>
                        </div>
                    </form>
                </div>
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
    </body>
</html>