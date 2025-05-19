<?php 
require 'function.php';
require 'cek.php';

// Tampilkan pesan sukses
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']); // Hapus pesan setelah ditampilkan
}

// Tampilkan pesan error
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']); // Hapus pesan setelah ditampilkan
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
        <title>ADMINISTRASI DIVISI - Dashboard</title>
        <link rel="icon" type="image/jpeg" href="image/logo-bawaslu-provinsi.jpeg">
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
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
                    <a class="nav-link" href="academic_holidays.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                                Libur kantor
                            </a>
                </div>
            </nav>
        </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">SURAT MASUK & KELUAR</h1>
                        <ol class="breadcrumb mb-4"></ol>

        <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                    Tambah Surat
                </button>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Cari Surat Keluar
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Jenis Surat</th>
                                                <th>Tanggal</th>
                                                <th>Pengirim</th>
                                                <th>Penerima</th>
                                                <th>File</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                              $no= 1;
                                              $ambilsemuadatasurat = mysqli_query($conn,"select * from surat");
                                              while($fetcharray = mysqli_fetch_array($ambilsemuadatasurat)){
                                               $idS = $fetcharray['id_surat'];
                                                $jenis_surat = $fetcharray['jenis_surat'];
                                                $tanggal = $fetcharray['tanggal'];
                                                $pengirim = $fetcharray['pengirim'];
                                                $penerima = $fetcharray['penerima'];
                                                $file_path = $fetcharray['file_path'];
                                                ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $jenis_surat; ?></td>
                                                <td><?php echo $tanggal; ?></td>
                                                <td><?php echo $pengirim; ?></td>
                                                <td><?php echo $penerima; ?></td>
                                                <td><a href="<?= $file_path; ?>" download class="btn btn-success btn-sm"> Unduh</a></td>
                                                <td> 
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idS;?>">
                                                        edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idS;?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?=$idS;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Surat</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <form method="post" enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_surat" value="<?=$idS;?>">
                                                                <label for="jenis_surat">Jenis Surat</label>
                                                                <select name="jenis_surat" id="jenis_surat" class="form-control">
                                                                    <option value="masuk" <?= ($jenis_surat == 'masuk') ? 'selected' : ''; ?>>Masuk</option>
                                                                    <option value="keluar" <?= ($jenis_surat == 'keluar') ? 'selected' : ''; ?>>Keluar</option>
                                                                </select><br>
                                                                <label for="tanggal">Tanggal</label>
                                                                <input type="date" name="tanggal" value="<?=$tanggal;?>" class="form-control" required><br>
                                                                <label for="pengirim">Pengirim</label>
                                                                <input type="text" name="pengirim" value="<?=$pengirim;?>" class="form-control" required><br>
                                                                <label for="penerima">Penerima</label>
                                                                <input type="text" name="penerima" value="<?=$penerima;?>" class="form-control" required><br>
                                                                <label for="file_path">File Saat Ini: <a href="<?= $file_path; ?>" target="_blank"><?= basename($file_path); ?></a></label><br>
                                                                <label for="file_path">Ubah File (PDF/DOC/DOCX) - Kosongkan jika tidak ingin mengubah</label>
                                                                <input type="file" name="file_path" class="form-control" accept=".pdf,.doc,.docx">
                                                                <br>
                                                                <button type="submit" class="btn btn-primary" name="updatesurat">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- Delete Modal -->
                                            <div class="modal fade" id="delete<?=$idS;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Surat</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus surat <strong><?=$jenis_surat;?></strong>?
                                                                <input type="hidden" name="id_surat" value="<?=$idS;?>">
                                                                <br><br>
                                                                <button type="submit" class="btn btn-danger" name="Hapussurat">Hapus</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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
          <h4 class="modal-title">Tambah Surat Baru</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form method="post" enctype="multipart/form-data">
        <div class="modal-body">

        <!-- Jenis Surat -->
            <label for="jenis_surat" class="form-label">Jenis Surat</label>
            <select name="jenis_surat" id="jenis_surat" class="form-control">
                <option value="masuk">Masuk</option>
                <option value="keluar">Keluar</option>
            </select>
            <br>

        <!-- Tanggal -->
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
            <br>

        <!-- Pengirim -->
            <label for="pengirim" class="form-label">Pengirim</label>
            <input type="text" name="pengirim" id="pengirim" placeholder="Nama Pengirim" class="form-control" required>
            <br>

        <!-- Penerima -->
            <label for="penerima" class="form-label">Penerima</label>
            <input type="text" name="penerima" id="penerima" placeholder="Nama Penerima" class="form-control" required>
            <br>

        <!-- File Upload -->
            <label for="file_path">Upload File (PDF/DOC/DOCX)</label>
            <input type="file" name="file_path" class="form-control" accept=".pdf,.doc,.docx" required>
            <br>

        <!-- Tombol Submit -->
             <button type="submit" class="btn btn-primary" name="addsurat">Submit</button>
        </form>
        </div>  
      </div>
    </div>
  </div>
  
</div>
</html>
