<?php 
require 'function.php';
require 'cek.php';


if (!isset($_SESSION['log'])) {
    header("Location: Login.php");
    exit;
}

// Hitung jumlah dokumen
$queryadministrasi = mysqli_query($conn, "SELECT COUNT(*) as total FROM administrasi");
$dataadministrasi = mysqli_fetch_assoc($queryadministrasi);
$totalid_dokumen = $dataadministrasi['total'];
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
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
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
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Ringkasan Informasi Acara Untuk Anda</li>
                        </ol>
                        
                        <!-- Cards Ringkasan -->
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Dokumen</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">
                                            <?= ($totalid_dokumen > 0) ? $totalid_dokumen : 'Tidak ada' ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Pengguna Online</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#" id="online-users-count">0</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-info text-white mb-4">
                                    <div class="card-body">Event Mendatang</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#" id="upcoming-events-count">0</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Kalender dan Pengguna Online -->
                        <div class="row">
                            <!-- Kalender -->
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
                            
                            <!-- Pengguna Online -->
                            <div class="col-lg-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-users mr-1"></i>
                                        Pengguna Online
                                    </div>
                                    <div class="card-body" id="online-users-list">
                                        <p class="text-center">Memuat data pengguna online...</p>
                                    </div>
                                </div>
                                
                                <!-- Event Mendatang -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-bell mr-1"></i>
                                        Event Mendatang
                                    </div>
                                    <div class="card-body" id="upcoming-events">
                                        <p class="text-center">Memuat event mendatang...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pengumuman (tetap sama seperti sebelumnya) -->
                    </div>
                </main>
            </div>
        </div>
        
        <!-- Modal untuk Detail Event -->
        <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventModalLabel">Detail Event</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="eventModalBody">
                        <!-- Konten akan diisi oleh JavaScript -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
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
            
            // Fungsi untuk menampilkan detail event
            function showEventDetails(event) {
                var start = event.start ? event.start.toLocaleString() : '';
                var end = event.end ? event.end.toLocaleString() : '';
                
                var html = `
                    <h4>${event.title}</h4>
                    <p><strong>Waktu:</strong> ${start} - ${end}</p>
                    <p><strong>Lokasi:</strong> ${event.extendedProps.location || '-'}</p>
                    <p><strong>Deskripsi:</strong> ${event.extendedProps.description || '-'}</p>
                    <p><strong>Status:</strong> ${event.extendedProps.status || '-'}</p>
                `;
                
                $('#eventModalLabel').text(event.title);
                $('#eventModalBody').html(html);
                $('#eventModal').modal('show');
            }
            
            // Memuat daftar pengguna online
            function loadOnlineUsers() {
                $.ajax({
                    url: 'get_online_users.php',
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            var html = '';
                            if (response.data.length > 0) {
                                response.data.forEach(function(user) {
                                    var lastActive = new Date(user.last_activity);
                                    var timeAgo = getTimeAgo(lastActive);
                                    
                                    html += `
                                        <div class="online-user">
                                            <div class="status-dot"></div>
                                            <div>
                                                <strong>${user.name}</strong>
                                                <small class="text-muted d-block">${user.role} • ${timeAgo}</small>
                                            </div>
                                        </div>
                                    `;
                                });
                            } else {
                                html = '<p class="text-center">Tidak ada pengguna online</p>';
                            }
                            
                            $('#online-users-list').html(html);
                            $('#online-users-count').text(response.data.length);
                        }
                    }
                });
            }
            
            // Memuat event mendatang
            function loadUpcomingEvents() {
                $.ajax({
                    url: 'get_upcoming_events.php',
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            var html = '';
                            if (response.data.length > 0) {
                                response.data.forEach(function(event) {
                                    var start = new Date(event.start_datetime);
                                    var end = new Date(event.end_datetime);
                                    
                                    html += `
                                        <div class="mb-3">
                                            <h6 class="mb-1">${event.title}</h6>
                                            <small class="text-muted d-block">
                                                <i class="far fa-calendar-alt"></i> ${start.toLocaleDateString()}
                                                <i class="far fa-clock ml-2"></i> ${start.toLocaleTimeString()} - ${end.toLocaleTimeString()}
                                            </small>
                                            <small class="d-block text-truncate">${event.description || ''}</small>
                                        </div>
                                    `;
                                });
                            } else {
                                html = '<p class="text-center">Tidak ada event mendatang</p>';
                            }
                            
                            $('#upcoming-events').html(html);
                            $('#upcoming-events-count').text(response.data.length);
                        }
                    }
                });
            }
            
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
        </script>
    </body>
</html>