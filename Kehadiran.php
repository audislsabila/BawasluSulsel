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
        .img-preview {
            max-width: 100px;
            max-height: 100px;
            cursor: pointer;
        }
        .img-modal {
            max-width: 100%;
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
            </nav>
        </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Ringkasan Informasi Acara Untuk Anda</li>
                        </ol>
                    <!-- Button to Open the Modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                            Update Kehadiran
                        </button>
                        <div class="card mt-3">
                        <div class="card text-white mb-4" style="background-color:rgb(137, 123, 147);">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="fw-bold">Pengumuman <span class="badge bg-secondary">1</span> 
                                <p><small class="text-muted">Publikasi: 06-10-2023</small></p>
                            </div>
                        </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    <i class="fas fa-bullhorn fa-2x me-3 text-primary"></i>
                                    <div>
                                        <h5 class="fw-bold"> Anggota Panitia Divisi</h5>
                                        <p>
                                        Setiap menjelang akhir kegiatan evaluasi, anggota diharapkan berpartisipasi dalam pengisian Absensi penilaian kinerja. 
                                        Jumlah Absensi yang harus diisi sesuai dengan jumlah anggota rapat atau peserta acara dan tugas yang telah dijalankan selama kegiatan tersebut berlngsung.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>                   <th>No</th>
                                                <th>Judul</th>
                                                <th>Tanggal</th>
                                                <th>Nama File</th>
                                                <th>Upload Absensi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $no = 1;
                                            $ambilsemuadatalaporan = mysqli_query($conn, "SELECT * FROM laporan_kehadiran");
                                            while ($fetcharray = mysqli_fetch_array($ambilsemuadatalaporan)) {
                                               $idK = $fetcharray['id_kehadiran'];
                                                $judul = $fetcharray['judul'];
                                                $tanggal = $fetcharray['tanggal'];
                                                $file_path = $fetcharray['file_path'];
                                                $file_name = $fetcharray['file_name'];
                                            ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $judul; ?></td>
                                                <td><?php echo $tanggal; ?></td>                               
                                                <td><a href="<?= $file_path; ?>" download class="btn btn-success btn-sm"> Unduh</a></td>
                                                <td><a href="<?= $file_name; ?>" target="_blank"><img src="<?= $file_name; ?>" alt="Absensi" style="max-width: 100px;"></a></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idK;?>">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idK;?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                           <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?=$idK;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Laporan Kehadiran</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <form method="post" enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_kehadiran" value="<?=$idK;?>">
                                                                
                                                                <div class="form-group">
                                                                    <label>Judul:</label>
                                                                    <input type="text" name="judul" value="<?=$judul;?>" class="form-control" required>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label>Tanggal:</label>
                                                                    <input type="date" name="tanggal" value="<?=$tanggal;?>" class="form-control" required>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label>Dokumen (PDF/DOC/DOCX):</label>
                                                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                                                                    <input type="file" name="file_path" class="form-control">
                                                                    <small>File saat ini: <a href="<?=$file_path;?>" target="_blank"><?=basename($file_path);?></a></small>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label>Gambar (JPG/PNG):</label>
                                                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                                                                    <input type="file" name="file_name" class="form-control">
                                                                    <small>File saat ini: <a href="<?=$file_name;?>" target="_blank"><?=basename($file_name);?></a></small>
                                                                </div>
                                                                
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                                    <button type="submit" class="btn btn-primary" name="editkehadiran">Simpan Perubahan</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                           <!-- Delete Modal -->
                                            <div class="modal fade" id="delete<?=$idK;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Laporan Kehadiran</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_kehadiran" value="<?=$idK;?>">
                                                                <p>Apakah Anda yakin ingin menghapus laporan ini?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-danger" name="hapuskehadiran">Hapus</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            }
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
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
    <!-- The Modal -->
        <div class="modal fade" id="myModal">
        <div class="modal-dialog">
        <div class="modal-content">  
      
    <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Form untuk menambahkan data -->
        <form method="POST" action="upload.php" enctype="multipart/form-data">
       
        <!-- Input Judul -->
        <label for="judul" class="form-label">Judul:</label>
        <input type="text" name="judul" id="judul" class="form-control" required>
        <br>

        <!-- Input Tanggal -->
        <label for="tanggal" class="form-label">Tanggal:</label>
        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
        <br>

        <label for="file_path">Dokumen (PDF/DOC/DOCX):</label>
        <input type="file" name="file_path" id="file_path" class="form-control-file" required>
        <br>

        <!-- Input File -->
        <label for="file_name">Gambar (JPG/PNG):</label>
        <input type="file" name="file_name" id="file_name" class="form-control-file" required>
        <br>

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-primary" name="addkehadiran">Submit</button>
        </form>

</html>
