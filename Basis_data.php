<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
        .detail-img {
            max-width: 200px;
            max-height: 200px;
            display: block;
            margin: 0 auto 15px;
            border-radius: 5px;
        }
        .detail-label {
            font-weight: bold;
            color: #495057;
        }
        .detail-value {
            margin-bottom: 10px;
            padding: 8px;
            background-color: #f8f9fa;
            border-radius: 4px;
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
                                Data Anggota
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
                    <h1 class="mt-4">BASIS DATA</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Ringkasan Informasi Acara Untuk Anda</li>
                    </ol>
                    <?php if(isset($_GET['success']) && $_GET['success'] == 'delete'): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        Data berhasil dihapus!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php endif; ?>
                    <!-- Button to Open the Modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        Input anggota
                    </button>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Cari Data Anggota Bawaslu 
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>NIP</th>
                                        <th>Nama Lengkap</th>
                                        <th>Jabatan</th>
                                        <th>Divisi</th>
                                        <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $ambilsemuadatabasis_data = mysqli_query($conn," SELECT * FROM basis_data");
                                        $no = 1;
                                        while ($fetcharray = mysqli_fetch_array($ambilsemuadatabasis_data)) {
                                            $id_anggota = $fetcharray['id_anggota'];
                                            $nip = $fetcharray['nip'];
                                            $nama_lengkap = $fetcharray['nama_lengkap'];
                                            $jabatan = $fetcharray['jabatan'];
                                            $divisi = $fetcharray['divisi'];
                                            $no_hp = $fetcharray['no_hp'];
                                            $email = $fetcharray['email'];
                                            $tanggal_lahir = $fetcharray['tanggal_lahir'];
                                            $tanggal_masuk = $fetcharray['tanggal_masuk'];
                                            $alamat = $fetcharray['alamat'];
                                            $foto = $fetcharray['foto'];
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $nip; ?></td>
                                            <td><?= $nama_lengkap; ?></td>
                                            <td><?= $jabatan; ?></td>
                                            <td><?= $divisi; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#detail<?=$id_anggota;?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit<?=$id_anggota;?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete<?=$id_anggota;?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        
                                        <!-- Detail Modal -->
                                        <div class="modal fade" id="detail<?=$id_anggota;?>">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h4 class="modal-title">Detail Anggota</h4>
                                                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-4 text-center">
                                                                <?php if($foto): ?>
                                                                    <img src="uploads/<?=$foto?>" class="detail-img img-thumbnail" alt="Foto Anggota">
                                                                <?php else: ?>
                                                                    <img src="https://via.placeholder.com/200" class="detail-img img-thumbnail" alt="Foto Default">
                                                                <?php endif; ?>
                                                                <h4 class="mt-2"><?=$nama_lengkap?></h4>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="detail-label">NIP</div>
                                                                        <div class="detail-value"><?=$nip?></div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="detail-label">Jabatan</div>
                                                                        <div class="detail-value"><?=$jabatan?></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="detail-label">Divisi</div>
                                                                        <div class="detail-value"><?=$divisi?></div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="detail-label">No HP</div>
                                                                        <div class="detail-value"><?=$no_hp?></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="detail-label">Email</div>
                                                                        <div class="detail-value"><?=$email?></div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="detail-label">Tanggal Lahir</div>
                                                                        <div class="detail-value"><?=date('d F Y', strtotime($tanggal_lahir))?></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="detail-label">Tanggal Masuk</div>
                                                                        <div class="detail-value"><?=date('d F Y', strtotime($tanggal_masuk))?></div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="detail-label">Usia</div>
                                                                        <div class="detail-value">
                                                                            <?php 
                                                                                $birthDate = new DateTime($tanggal_lahir);
                                                                                $today = new DateTime();
                                                                                $age = $today->diff($birthDate)->y;
                                                                                echo $age . ' tahun';
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="detail-label">Alamat</div>
                                                                        <div class="detail-value"><?=$alamat?></div>
                                                                    </div>
                                                                </div>
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
                                        <div class="modal fade" id="edit<?=$id_anggota;?>">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Anggota</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <form method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id_anggota" value="<?=$id_anggota;?>">
                                                            
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>NIP</label>
                                                                        <input type="text" name="nip" value="<?=$nip;?>" class="form-control" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Nama Lengkap</label>
                                                                        <input type="text" name="nama_lengkap" value="<?=$nama_lengkap;?>" class="form-control" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Jabatan</label>
                                                                        <input type="text" name="jabatan" value="<?=$jabatan;?>" class="form-control" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Divisi</label>
                                                                        <input type="text" name="divisi" value="<?=$divisi;?>" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>No HP</label>
                                                                        <input type="text" name="no_hp" value="<?=$no_hp;?>" class="form-control" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Email</label>
                                                                        <input type="email" name="email" value="<?=$email;?>" class="form-control" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Tanggal Lahir</label>
                                                                        <input type="date" name="tanggal_lahir" value="<?=$tanggal_lahir;?>" class="form-control" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Tanggal Masuk</label>
                                                                        <input type="date" name="tanggal_masuk" value="<?=$tanggal_masuk;?>" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label>Alamat</label>
                                                                <textarea name="alamat" class="form-control" required><?=$alamat;?></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Foto</label>
                                                                <input type="file" name="foto" class="form-control-file">
                                                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                                                                <?php if($foto): ?>
                                                                    <div class="mt-2">
                                                                        <small>Foto Saat Ini:</small><br>
                                                                        <img src="uploads/<?=$foto?>" width="100" class="img-thumbnail mt-1">
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            
                                                            <button type="submit" class="btn btn-primary" name="updatebasisdata">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="delete<?=$id_anggota;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Anggota</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <form method="post">
                                                        <input type="hidden" name="id_anggota" value="<?=$id_anggota;?>">
                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus anggota <strong><?=$nama_lengkap;?></strong>?
                                                            <div class="mt-3">
                                                                <button type="submit" name="hapusbasisdata" class="btn btn-danger">Hapus</button>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            </div>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>
    <script>
    $(document).ready(function() {
        $('.btn-danger[data-target^="#delete"]').click(function() {
            return confirm('Yakin ingin menghapus data ini?');
        });
    });
    </script>
</body>
 <!-- The Modal Tambah Data -->
 <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Anggota</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NIP</label>
                                    <input type="text" name="nip" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Jabatan</label>
                                    <input type="text" name="jabatan" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Divisi</label>
                                    <input type="text" name="divisi" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>No HP</label>
                                    <input type="text" name="no_hp" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Masuk</label>
                                    <input type="date" name="tanggal_masuk" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Foto</label>
                                    <input type="file" name="foto" class="form-control-file" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary" name="addbasisdata">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</html>