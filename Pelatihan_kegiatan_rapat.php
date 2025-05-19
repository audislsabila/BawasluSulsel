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
            @media print {
                .navbar form,
                .no-print,
                .aksi-column {
                    display: none !important;
                }
                
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                
                .header img {
                    margin-bottom: 10px;
                }
            }

            .print-only {
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
                        <h1 class="mt-4">KEGIATAN RAPAT</h1>
                        <ol class="breadcrumb mb-4"></ol>
                    <!-- Tombol Aksi -->
                    <div class="no-print">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                            Tambah Surat
                        </button>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <!-- Header Cetak -->
                            <div class="print-only">
                                <div class="header">
                                    <img src="https://3.bp.blogspot.com/-MYWK0OeoYfU/XJsBH5dmJ6I/AAAAAAAALYo/lLHintm61FANouhpNd6uzuqPs3PgapS2wCLcBGAs/s1600/logo-bawaslu%2BPersegi.png" width="200" alt="logo Bawaslu Provinsi Sulawesi Selatan">
                                    <h5>BAWASLU PROVINSI SULAWESI SELATAN</h5>
                                    <h6>BADAN PENGAWASAN PEMILIHAN UMUM</h6>
                                    <p>Alamat : Jl. A. P. Pettarani No.98, Bua Kana, Kec. Rappocini, Kota Makassar, Sulawesi Selatan 90222</p>
                                    <h3 class="text-center">RIWAYAT AKTIVITAS KEGIATAN DIVISI BAWASLU</h3>
                                </div>
                            </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Divisi</th>
                                                <th>Jenis Kegiatan</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Tanggal Selesai</th>
                                                <th>Status</th>
                                                <th>Dokumen ID</th>
                                                <th class="aksi-column">Aksi</th>                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                              $no= 1;
                                              $ambilsemuadatakegiatan = mysqli_query($conn, "SELECT * FROM kegiatan");
                                              while($fetcharray = mysqli_fetch_array($ambilsemuadatakegiatan)){
                                               $idR= $fetcharray['id_kegiatan'];
                                               $divisi = $fetcharray['divisi'];
                                               $jenis_kegiatan = $fetcharray['jenis_kegiatan'];
                                               $tanggal_mulai = $fetcharray['tanggal_mulai'];
                                               $tanggal_selesai = $fetcharray['tanggal_selesai'];   
                                               $status = $fetcharray['status'];
                                               $dokumen_id = $fetcharray['dokumen_id'];
                                            ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $divisi; ?></td>
                                                <td><?php echo  $jenis_kegiatan; ?></td>
                                                <td><?php echo $tanggal_mulai; ?></td>
                                                <td><?php echo $tanggal_selesai; ?></td>
                                                <td><?php echo $status ; ?></td>
                                                <td><?php echo $dokumen_id; ?></td>
                                                <td> 
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idR;?>">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idR;?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?=$idR;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Surat</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <form method="post">
                                                            <<!-- Di dalam modal edit (#edit<?=$idR;?>) -->
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id_kegiatan" value="<?=$idR;?>">
                                                            
                                                            <label>Divisi</label>
                                                            <input type="text" name="divisi" value="<?=$divisi;?>" class="form-control" required>
                                                            
                                                            <label>Jenis Kegiatan</label>
                                                            <input type="text" name="jenis_kegiatan" value="<?=$jenis_kegiatan;?>" class="form-control" required>
                                                            
                                                            <label>Tanggal Mulai</label>
                                                            <input type="date" name="tanggal_mulai" value="<?=$tanggal_mulai;?>" class="form-control" required>
                                                            
                                                            <label>Tanggal Selesai</label>
                                                            <input type="date" name="tanggal_selesai" value="<?=$tanggal_selesai;?>" class="form-control" required>
                                                            
                                                            <label>Status</label>
                                                            <select name="status" class="form-control">
                                                                <option value="Selesai" <?=($status=='Selesai')?'selected':''?>>Selesai</option>
                                                                <option value="Tertunda" <?=($status=='Tertunda')?'selected':''?>>Tertunda</option>
                                                            </select>
                                                            
                                                            <label>Dokumen ID</label>
                                                            <input type="number" name="dokumen_id" value="<?=$dokumen_id;?>" class="form-control" required>
                                                            
                                                            <button type="submit" class="btn btn-primary mt-3" name="updatekegiatan">Update</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- Delete Modal -->
                                            <div class="modal fade" id="delete<?=$idR;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Kegiatan Rapat</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus kegiatan rapat <strong><?=$idR;?></strong>?
                                                                <input type="hidden" name="id_kegiatan" value="<?=$idR;?>">                                                                 <br><br>
                                                                <button type="submit" class="btn btn-danger" name="hapuskegiatan">Hapus</button>
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
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
        <script>
            // Fungsi Download PDF
            function downloadPDF() {
                // Clone tabel dan hapus kolom aksi
                const tableClone = document.getElementById('dataTable').cloneNode(true);
                Array.from(tableClone.getElementsByClassName('aksi-column')).forEach(col => col.remove());
                Array.from(tableClone.getElementsByClassName('edit-colum')).forEach(col => col.remove());
                Array.from(tableClone.getElementsByClassName('delete-colum')).forEach(col => col.remove());

                
                // Hapus header aksi
                const headerRow = tableClone.rows[0];
                if(headerRow.cells.length > 0) headerRow.deleteCell(-1);

                html2canvas(tableClone).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const pdf = new jspdf.jsPDF('p', 'mm', 'a4');
                    const imgWidth = pdf.internal.pageSize.getWidth();
                    const imgHeight = (canvas.height * imgWidth) / canvas.width;
                    
                    pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
                    pdf.save('Laporan-Kegiatan-Rapat.pdf');
                });
            }
            @media print {
                .navbar form,
                .no-print,
                .aksi-column {
                    display: none !important;
                }
                /* ... */
            }
        </script>
        
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
        
        <!-- Modal body -->
        <form method="post">
        <div class="modal-body">
        <input type="hidden" name="id_kegiatan" value="<?=$idR;?>">

        <label for="divisi"  class="form-label">Divisi</label>
        <input type="text" name="divisi" class="form-control" required>
        <br>
        <label for="jenis_kegiatan" class="form-label">Jenis Kegiatan</label>
        <input type="text" name="jenis_kegiatan" class="form-control" required>
        <br>
        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
        <br>

        <label for="tanggal_selesai">Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai" class="form-control" required>
        <br>

        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-control">
            <option value="Selesai">Selesai</option>
            <option value="Tertunda">Tertunda</option>
        </select>
        <br>

        <label for="dokumen_id" class="form-label">Dokumen ID (Opsional)</label>
        <input type="number" name="dokumen_id" id="dokumen_id" class="form-control" required>
        <br>

        <button type="submit" class="btn btn-primary" name="addkegiatan">Simpan</button>
        </form>
        </div>  
      </div>
    </div>
  </div>
</div>
</html>
