<?php 
require 'function.php';
require 'cek.php';


if (!isset($_SESSION['log'])) {
    header("Location: Login.php");
    exit;
}
// Hitung jumlah pelatihan
$querykegiatan = mysqli_query($conn, "SELECT COUNT(*) as total FROM kegiatan");
$datakegiatan = mysqli_fetch_assoc($querykegiatan);
$totalid_kegiatan = $datakegiatan['total'];

// Hitung jumlah dokumen
$queryadministrasi = mysqli_query($conn, "SELECT COUNT(*) as total FROM administrasi");
$dataadministrasi = mysqli_fetch_assoc($queryadministrasi);
$totalid_dokumen = $dataadministrasi['total'];

// Hitung jumlah surat
$querysurat = mysqli_query($conn, "SELECT COUNT(*) as total FROM surat");
$datasurat = mysqli_fetch_assoc($querysurat);
$totalid_surat = $datasurat['total'];

// Hitung jumlah agenda rapat
$queryagenda_rapat = mysqli_query($conn, "SELECT COUNT(*) as total FROM agenda_rapat");
$dataagenda_rapat = mysqli_fetch_assoc($queryagenda_rapat);
$totalid_rapat = $dataagenda_rapat['total'];
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
            .fc-event {
                cursor: pointer;
            }
            .online-user {
                display: flex;
                align-items: center;
                margin-bottom: 10px;
                padding: 5px;
                border-radius: 5px;
                background-color: #f8f9fa;
            }
            .online-user .status-dot {
                width: 10px;
                height: 10px;
                border-radius: 50%;
                background-color: #28a745;
                margin-right: 10px;
            }
                @media (max-width: 991.98px) {
        .sb-sidenav {
            position: fixed;
            top: 56px; /* Tinggi navbar */
            left: -250px;
            width: 250px;
            height: calc(100vh - 56px);
            z-index: 1000;
            transition: all 0.3s;
        }
        
        .sb-sidenav.sb-sidenav-toggled {
            left: 0;
        }
        
        #layoutSidenav_content {
            margin-left: 0;
        }
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
        <!-- Di dalam navbar (setelah dropdown user) -->
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
                        
                        <!-- Cards Ringkasan -->
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-secondary text-white mb-4">
                                    <div class="card-body">Pelatihan Anggota Bawaslu</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="Pelatihan_kegiatan_rapat.php">
                                            Jumlah : <?=$totalid_kegiatan?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Dokumen</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="administrasi_user.php">
                                             Jumlah : <?=$totalid_dokumen?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Surat Masuk/Keluar</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="Surat.php">
                                             Jumlah : <?=$totalid_surat?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-info text-white mb-4">
                                    <div class="card-body">Agenda Rapat</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="agenda_rapat_user.php">
                                             Jumlah : <?=$totalid_rapat?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Kalender dan Pengguna Online -->
                            <div class="row">
                                <!-- Kalender (8 kolom) -->
                                <div class="col-lg-8">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-calendar-alt mr-1"></i>
                                            Kalender Kegiatan
                                        </div>
                                        <div class="card-body">
                                            <div id="calendar"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Libur Akademik (4 kolom) -->
                                <div class="col-lg-4">
                                    <div class="card card-custom mb-4">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <span>Libur Kantor</span>
                                            <span class="text-muted" style="cursor:pointer;"><i class="fas fa-minus"></i></span>
                                        </div>
                                        <div class="card-body">
                                            <?php
                                            $queryHolidays = mysqli_query($conn, "SELECT * FROM academic_holidays 
                                                                                WHERE start_date >= CURDATE() 
                                                                                ORDER BY start_date 
                                                                                LIMIT 3");
                                            $holidays = mysqli_fetch_all($queryHolidays, MYSQLI_ASSOC);
                                            ?>
                                            <div class="academic-holidays">
                                                <?php if(count($holidays) > 0): ?>
                                                    <?php foreach($holidays as $holiday): ?>
                                                        <div class="holiday-item">
                                                            <div class="holiday-bar bg-<?= $holiday['color'] ?>"></div>
                                                            <div class="holiday-content">
                                                                <div class="holiday-title"><?= $holiday['title'] ?></div>
                                                                <div class="holiday-date">
                                                                    <?= date('d-m-Y', strtotime($holiday['start_date'])) ?>
                                                                    <?= $holiday['end_date'] ? ' s/d '.date('d-m-Y', strtotime($holiday['end_date'])) : '' ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <div class="text-center py-3">Tidak ada libur mendatang</div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
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
            
            // Fungsi untuk menampilkan waktu lalu (time ago)
            function getTimeAgo(date) {
                var seconds = Math.floor((new Date() - date) / 1000);
                var interval = Math.floor(seconds / 31536000);
                
                if (interval >= 1) return interval + " tahun lalu";
                interval = Math.floor(seconds / 2592000);
                if (interval >= 1) return interval + " bulan lalu";
                interval = Math.floor(seconds / 86400);
                if (interval >= 1) return interval + " hari lalu";
                interval = Math.floor(seconds / 3600);
                if (interval >= 1) return interval + " jam lalu";
                interval = Math.floor(seconds / 60);
                if (interval >= 1) return interval + " menit lalu";
                return "baru saja";
            }
            
            // Muat data awal
            loadOnlineUsers();
            loadUpcomingEvents();
            
            // Perbarui setiap 30 detik
            setInterval(function() {
                loadOnlineUsers();
                loadUpcomingEvents();
            }, 30000);
        });
    // Script untuk toggle sidebar
    document.getElementById('sidebarToggle').addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector('.sb-sidenav').classList.toggle('sb-sidenav-toggled');
        
        // Simpan state sidebar di localStorage
        const isToggled = document.querySelector('.sb-sidenav').classList.contains('sb-sidenav-toggled');
        localStorage.setItem('sb|sidebar-toggle', isToggled);
    });

    // Restore state sidebar saat halaman dimuat
    window.addEventListener('DOMContentLoaded', () => {
        const isToggled = localStorage.getItem('sb|sidebar-toggle') === 'true';
        if (isToggled) {
            document.querySelector('.sb-sidenav').classList.add('sb-sidenav-toggled');
        }
    });
        </script>
    </body>
</html>