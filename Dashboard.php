<?php 
require 'function.php';
require 'cek.php';

if (!isset($_SESSION['log'])) {
    header("Location: Login.php");
    exit;
}
// Hitung jumlah dokumen
$querybasis_data = mysqli_query($conn, "SELECT COUNT(*) as total FROM basis_data");
$databasis_data = mysqli_fetch_assoc($querybasis_data);
$totalid_anggota = $databasis_data['total'];

// Hitung jumlah agenda rapat
$queryagenda_rapat = mysqli_query($conn, "SELECT COUNT(*) as total FROM agenda_rapat");
$dataagenda_rapat = mysqli_fetch_assoc($queryagenda_rapat);
$totalid_rapat = $dataagenda_rapat['total'];

// Hitung jumlah dokumen
$queryadministrasi = mysqli_query($conn, "SELECT COUNT(*) as total FROM administrasi");
$dataadministrasi = mysqli_fetch_assoc($queryadministrasi);
$totalid_dokumen = $dataadministrasi['total'];

// Hitung jumlah dokumen
$querystatistik = mysqli_query($conn, "SELECT COUNT(*) as total FROM statistik");
$datastatistik = mysqli_fetch_assoc($querystatistik);
$totalid_statistik = $datastatistik['total'];
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
            .upcoming-event {
                transition: all 0.3s ease;
            }
            .upcoming-event:hover {
                background-color: #f8f9fa;
                transform: translateY(-2px);
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            }
            .event-meta h5 {
                font-size: 1rem;
                margin-bottom: 0.3rem;
            }
            .event-detail-container {
                max-height: 70vh;
                overflow-y: auto;
                padding-right: 10px;
            }
             .bg-maroon {
                background-color: maroon !important;
            }
            .bg-chocolate {
                background-color: #D2691E !important;
            }
            .bg-gray-dark {
                background-color: #2f2f2f !important;
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
                                        <a class="small text-white stretched-link" href="Administrasi.php">
                                            <?= ($totalid_dokumen > 0) ? $totalid_dokumen : 'Tidak ada' ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-gray-dark  text-white mb-4">
                                    <div class="card-body">Agenda Rapate</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                          <a class="small text-white stretched-link" href="agenda_rapat.php">
                                            <?= ($totalid_rapat > 0) ? $totalid_rapat : 'Tidak ada' ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-chocolate text-white mb-4">
                                    <div class="card-body">Data Anggota</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="Basis_data.php">
                                            <?= ($totalid_anggota > 0) ? $totalid_anggota : 'Tidak ada' ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-maroon text-white mb-4">
                                    <div class="card-body">Statistik & Laporan</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="statistik_laporan.php">
                                            <?= ($totalid_statistik > 0) ? $totalid_statistik : 'Tidak ada' ?>
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
                                        <div class="card-footer">
                                            <a href="academic_holidays.php" class="btn btn-link btn-sm btn-block">
                                                Lihat Semua Libur <i class="fas fa-arrow-right"></i>
                                            </a>
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
            
            // Fungsi untuk memuat event mendatang
            function loadUpcomingEvents() {
                // Tampilkan loading state
                $('#upcoming-events').html('<p class="text-center"><i class="fas fa-spinner fa-spin"></i> Memuat event...</p>');
                
                $.ajax({
                    url: 'get_upcoming_events.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            var html = '';
                            if (response.data.length > 0) {
                                response.data.forEach(function(event) {
                                    var start = new Date(event.start_datetime);
                                    var end = new Date(event.end_datetime);
                                    
                                    // Format tanggal dan waktu (lebih rapi)
                                    var dateStr = start.toLocaleDateString('id-ID', {
                                        weekday: 'short',
                                        day: 'numeric',
                                        month: 'short'
                                    });
                                    
                                    var timeStr = start.toLocaleTimeString('id-ID', {
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    }) + ' - ' + end.toLocaleTimeString('id-ID', {
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    });
                                    
                                    // Tentukan ikon berdasarkan jenis event (contoh sederhana)
                                    var eventIcon = event.location && event.location.toLowerCase().includes('online') ? 
                                        '<i class="fas fa-video"></i>' : '<i class="far fa-calendar-alt"></i>';
                                    
                                    html += `
                                        <div class="mb-3 upcoming-event p-3 border rounded" data-id="${event.id}">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <h6 class="mb-1 font-weight-bold">${event.title}</h6>
                                                <span class="badge ${event.status === 'published' ? 'badge-success' : 'badge-secondary'}">
                                                    ${event.status === 'published' ? 'Aktif' : 'Draft'}
                                                </span>
                                            </div>
                                            <small class="text-muted d-block mb-1">
                                                ${eventIcon} ${dateStr} • ${timeStr}
                                            </small>
                                            <small class="d-block mb-2">
                                                <i class="fas fa-map-marker-alt"></i> ${event.location || 'Belum ditentukan'}
                                            </small>
                                            <button class="btn btn-sm btn-outline-primary btn-view-details" 
                                                data-id="${event.id}">
                                                <i class="fas fa-info-circle"></i> Detail
                                            </button>
                                        </div>
                                    `;
                                });
                            } else {
                                html = `
                                    <div class="text-center py-4">
                                        <i class="far fa-calendar-plus fa-2x mb-2 text-muted"></i>
                                        <p class="text-muted">Tidak ada event mendatang dalam 30 hari ke depan</p>
                                        <button class="btn btn-sm btn-primary" onclick="window.location.href='add_event_form.php'">
                                            <i class="fas fa-plus"></i> Buat Event Baru
                                        </button>
                                    </div>
                                `;
                            }
                            
                            $('#upcoming-events').html(html);
                            $('#upcoming-events-count').text(response.data.length);
                            
                            // Update card count color based on number of events
                            if (response.data.length > 0) {
                                $('#upcoming-events-count').parent().parent().removeClass('bg-info').addClass('bg-primary');
                            } else {
                                $('#upcoming-events-count').parent().parent().removeClass('bg-primary').addClass('bg-info');
                            }
                            
                            // Tambahkan event listener untuk tombol detail
                            $('.btn-view-details').off('click').on('click', function() {
                                var eventId = $(this).data('id');
                                viewEventDetails(eventId);
                            });
                        } else {
                            $('#upcoming-events').html(`
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i> ${response.message || 'Gagal memuat event'}
                                </div>
                            `);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#upcoming-events').html(`
                            <div class="alert alert-danger">
                                <i class="fas fa-times-circle"></i> Error: ${xhr.statusText || 'Gagal memuat data'}
                            </div>
                        `);
                        console.error('Error loading upcoming events:', error);
                    }
                });
            }

            // Fungsi untuk menampilkan detail event
            function viewEventDetails(eventId) {
                // Tampilkan loading spinner di modal
                $('#eventModalLabel').text('Memuat Detail...');
                $('#eventModalBody').html('<div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x"></i></div>');
                $('#eventModal').modal('show');
                
                $.ajax({
                    url: 'get_event_details.php',
                    method: 'GET',
                    data: { id: eventId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            var event = response.data;
                            var start = new Date(event.start_datetime);
                            var end = new Date(event.end_datetime);
                            
                            // Format tanggal dan waktu
                            var dateOptions = { 
                                weekday: 'long', 
                                day: 'numeric', 
                                month: 'long', 
                                year: 'numeric' 
                            };
                            var timeOptions = { 
                                hour: '2-digit', 
                                minute: '2-digit' 
                            };
                            
                            var dateStr = start.toLocaleDateString('id-ID', dateOptions);
                            var startTimeStr = start.toLocaleTimeString('id-ID', timeOptions);
                            var endTimeStr = end.toLocaleTimeString('id-ID', timeOptions);
                            
                            // Cek apakah user adalah pembuat event atau admin
                            var isCreatorOrAdmin = <?= ($_SESSION['role'] == 'admin' || isset($_SESSION['id'])) ? 'true' : 'false' ?>;
                            var editButton = isCreatorOrAdmin ? 
                                `<a href="edit_event.php?id=${event.id}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>` : '';
                            
                            var html = `
                                <div class="event-detail-container">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="mb-0">${event.title}</h4>
                                        <span class="badge ${event.status === 'published' ? 'badge-success' : 'badge-secondary'}">
                                            ${event.status === 'published' ? 'Aktif' : 'Draft'}
                                        </span>
                                    </div>
                                    
                                    <div class="event-meta mb-4">
                                        <div class="meta-item mb-2">
                                            <h5><i class="far fa-calendar-alt text-primary"></i> Tanggal & Waktu</h5>
                                            <p>${dateStr}, ${startTimeStr} - ${endTimeStr}</p>
                                        </div>
                                        
                                        <div class="meta-item mb-2">
                                            <h5><i class="fas fa-map-marker-alt text-danger"></i> Lokasi</h5>
                                            <p>${event.location || 'Belum ditentukan'}</p>
                                        </div>
                                        
                                        <div class="meta-item">
                                            <h5><i class="fas fa-user-tie text-info"></i> Penanggung Jawab</h5>
                                            <p>${event.creator_name || 'Admin'}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="event-description mb-4">
                                        <h5><i class="fas fa-align-left text-success"></i> Deskripsi</h5>
                                        <div class="bg-light p-3 rounded">
                                            ${event.description || '<em>Tidak ada deskripsi</em>'}
                                        </div>
                                    </div>
                                    
                                    <div class="event-actions text-right">
                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                                            <i class="fas fa-times"></i> Tutup
                                        </button>
                                        ${editButton}
                                        <button class="btn btn-primary btn-sm btn-add-to-calendar" 
                                            data-title="${event.title}" 
                                            data-start="${event.start_datetime}" 
                                            data-end="${event.end_datetime}" 
                                            data-location="${event.location || ''}">
                                            <i class="far fa-calendar-plus"></i> Tambah ke Kalender
                                        </button>
                                    </div>
                                </div>
                            `;
                            
                            $('#eventModalLabel').text('Detail Event');
                            $('#eventModalBody').html(html);
                            
                            // Tambahkan event listener untuk tombol tambah ke kalender
                            $('.btn-add-to-calendar').on('click', function() {
                                addToCalendar(
                                    $(this).data('title'),
                                    $(this).data('start'),
                                    $(this).data('end'),
                                    $(this).data('location')
                                );
                            });
                        } else {
                            $('#eventModalBody').html(`
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i> ${response.message || 'Event tidak ditemukan'}
                                </div>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            `);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#eventModalBody').html(`
                            <div class="alert alert-danger">
                                <i class="fas fa-times-circle"></i> Error: ${xhr.statusText || 'Gagal memuat detail event'}
                            </div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        `);
                        console.error('Error loading event details:', error);
                    }
                });
            }

            // Fungsi untuk menambahkan event ke kalender pengguna
            function addToCalendar(title, start, end, location) {
                // Format tanggal untuk kalender
                var startDate = new Date(start);
                var endDate = new Date(end);
                
                // Buat link untuk Google Calendar
                var googleCalendarUrl = 'https://www.google.com/calendar/render?action=TEMPLATE';
                googleCalendarUrl += '&text=' + encodeURIComponent(title);
                googleCalendarUrl += '&dates=' + startDate.toISOString().replace(/-|:|\.\d\d\d/g, '');
                googleCalendarUrl += '/' + endDate.toISOString().replace(/-|:|\.\d\d\d/g, '');
                googleCalendarUrl += '&location=' + encodeURIComponent(location || '');
                googleCalendarUrl += '&details=' + encodeURIComponent('Event dari sistem Bawaslu');
                
                // Buka link di tab baru
                window.open(googleCalendarUrl, '_blank');
                
                // Tampilkan notifikasi sukses
                alert('Event telah ditambahkan ke Google Calendar. Anda dapat mengimpor event ini ke kalender lain jika diperlukan.');
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
            }, 30000);
            
            // Perbarui event setiap 2 menit
            setInterval(loadUpcomingEvents, 120000);
            
            // Tambahkan event listener untuk tombol refresh manual
            $('#refresh-events').on('click', function() {
                loadUpcomingEvents();
            });
        });
        </script>
    </body>
</html>