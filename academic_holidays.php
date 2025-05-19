<?php
require 'function.php';
require 'cek.php';

// Handle Delete Action
if(isset($_POST['deleteHoliday'])){
    $id_libur = $_POST['id_libur'];
    
    // Validasi ID
    if(!is_numeric($id_libur)){
        echo "<script>alert('ID tidak valid!');</script>";
        exit;
    }
    
    // Gunakan prepared statement
$stmt = $conn->prepare("DELETE FROM academic_holidays WHERE id_libur = ?");    
    if($stmt === false){
        die("Error preparing statement: " . $conn->error);
    }
    
    $stmt->bind_param("i", $id_libur);
    
    if($stmt->execute()){
        echo "<script>
            alert('Libur berhasil dihapus');
            window.location.href = 'academic_holidays.php';
            </script>";
    } else {
        echo "<script>alert('Gagal menghapus: ".$stmt->error."');</script>";
    }
    
    $stmt->close();
}

// Ambil data libur
$queryHolidays = mysqli_query($conn, "SELECT * FROM academic_holidays ORDER BY start_date");
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
        <title>ADMINISTRASI DIVISI - Dashboard Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <style>
            /* Academic Holidays Style */
.academic-holidays {
    margin-top: 15px;
    max-height: 300px;
    overflow-y: auto;
}

.holiday-item {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    padding: 8px;
    background: rgba(255,255,255,0.1);
    border-radius: 4px;
    transition: transform 0.2s;
}

.holiday-item:hover {
    transform: translateX(5px);
    background: rgba(255,255,255,0.15);
}

.holiday-bar {
    width: 4px;
    height: 40px;
    border-radius: 2px;
    margin-right: 12px;
}

.holiday-content {
    flex: 1;
}

.holiday-title {
    font-size: 0.85rem;
    line-height: 1.2;
    margin-bottom: 2px;
    font-weight: 500;
}

.holiday-date {
    font-size: 0.75rem;
    opacity: 0.9;
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
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                     <div class="container-fluid">
                    <h1 class="mt-4">Kelola Libur Akademik</h1>
                    
                    <!-- Form Tambah Libur -->
                    <div class="card mb-4">
                        <div class="card-header">
                            Tambah Libur Baru
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-group">
                                    <label>Judul Libur</label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Mulai</label>
                                    <input type="date" name="start_date" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Selesai (opsional)</label>
                                    <input type="date" name="end_date" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Warna Label</label>
                                    <select name="color" class="form-control">
                                        <option value="primary">Biru</option>
                                        <option value="success">Hijau</option>
                                        <option value="warning">Kuning</option>
                                        <option value="danger">Merah</option>
                                        <option value="info">Biru Muda</option>
                                    </select>
                                </div>
                                <button type="submit" name="addHoliday" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                <!-- Tabel Daftar Libur -->
                        <div class="card mb-4">
                            <div class="card-header">
                                Daftar Libur Akademik
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Judul</th>
                                                <th>Tanggal</th>
                                                <th>Warna</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                                          <tbody>
                                        <?php 
                                        $no = 1;
                                        while($holiday = mysqli_fetch_assoc($queryHolidays)): 
                                            $id_libur = $holiday['id_libur'];
                                        ?>
                                        <tr>
                                            <td><?= $holiday['title'] ?></td>
                                            <td>
                                                <?= date('d-m-Y', strtotime($holiday['start_date'])) ?>
                                                <?= $holiday['end_date'] ? ' s/d '.date('d-m-Y', strtotime($holiday['end_date'])) : '' ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?= $holiday['color'] ?>">
                                                    <?= ucfirst($holiday['color']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$id_libur?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$id_libur?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="edit<?=$id_libur?>" tabindex="-1" role="dialog" aria-labelledby="editLabel<?=$id_libur?>" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editLabel<?=$id_libur?>">Edit Libur</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="POST">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id_libur" value="<?=$id_libur?>">
                                                        <div class="form-group">
                                                            <label>Judul Libur</label>
                                                            <input type="text" name="title" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Tanggal Mulai</label>
                                                            <input type="date" name="start_date" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Tanggal Selesai (opsional)</label>
                                                            <input type="date" name="end_date" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Warna Label</label>
                                                            <select name="color" class="form-control">
                                                                <option value="primary">Biru</option>
                                                                <option value="success">Hijau</option>
                                                                <option value="warning">Kuning</option>
                                                                <option value="danger">Merah</option>
                                                                <option value="info">Biru Muda</option>
                                                            </select>
                                                        </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                            <button type="submit" name="updateHoliday" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="delete<?=$id_libur;?>" tabindex="-1" role="dialog" aria-labelledby="deleteLabel<?=$id_libur;?>" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteLabel<?=$id_libur;?>">Hapus Libur Akademik</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="POST">
                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus libur:
                                                            <h5 class="text-danger"><?= $holiday['title'] ?></h5>
                                                            <p>
                                                                Tanggal: <?= date('d-m-Y', strtotime($holiday['start_date'])) ?>
                                                                <?= $holiday['end_date'] ? ' s/d '.date('d-m-Y', strtotime($holiday['end_date'])) : '' ?>
                                                            </p>
                                                            <input type="hidden" name="id_libur" value="<?= $id_libur ?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger" name="deleteHoliday">Hapus</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </main>
        </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales/id.min.js"></script>
        
        <script>
        $(document).ready(function() {
            // Inisialisasi FullCalendar
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: {
                    url: 'get_calendar_events.php',
                    method: 'POST',
                    extraParams: {
                        user_id: <?= $_SESSION['id'] ?? 0 ?>
                    },
                    failure: function() {
                        alert('Gagal memuat data kalender');
                    }
                },
                eventClick: function(info) {
                    showEventDetails(info.event);
                },
                eventDidMount: function(info) {
                    // Tambahkan tooltip
                    $(info.el).tooltip({
                        title: info.event.title,
                        placement: 'top',
                        trigger: 'hover',
                        container: 'body'
                    });
                }
            });
            calendar.render();
            
          
        });
        </script>
    </body>
</html>