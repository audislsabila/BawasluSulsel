<?php
require 'function.php';
require 'cek.php';

if (!isset($_SESSION['log'])) {
    header("Location: Login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: Dashboard.php");
    exit;
}

$event_id = intval($_GET['id']);
$query = "SELECT * FROM events WHERE id = $event_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: Dashboard.php");
    exit;
}

$event = mysqli_fetch_assoc($result);

// Hanya pembuat event atau admin yang bisa mengedit
if ($_SESSION['id'] != $event['created_by'] && $_SESSION['role'] != 'admin') {
    header("Location: Dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="icon" type="image/jpeg" href="image/logo-bawaslu-provinsi.jpeg">
</head>
<body class="sb-nav-fixed">
    <?php include 'navbar.php'; ?>
    
    <div id="layoutSidenav">
        <?php include 'sidebar.php'; ?>
        
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Edit Event</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="Dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Event</li>
                    </ol>
                    
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-calendar-edit me-1"></i>
                            Form Edit Event
                        </div>
                        <div class="card-body">
                            <form action="update_event.php" method="post" id="eventForm">
                                <input type="hidden" name="id" value="<?= $event['id'] ?>">
                                
                                <div class="mb-3">
                                    <label for="title" class="form-label">Judul Event</label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="<?= htmlspecialchars($event['title']) ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="description" name="description" 
                                              rows="3"><?= htmlspecialchars($event['description']) ?></textarea>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="start_datetime" class="form-label">Waktu Mulai</label>
                                        <input type="datetime-local" class="form-control" id="start_datetime" 
                                               name="start_datetime" value="<?= date('Y-m-d\TH:i', strtotime($event['start_datetime'])) ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="end_datetime" class="form-label">Waktu Selesai</label>
                                        <input type="datetime-local" class="form-control" id="end_datetime" 
                                               name="end_datetime" value="<?= date('Y-m-d\TH:i', strtotime($event['end_datetime'])) ?>" required>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="location" class="form-label">Lokasi</label>
                                    <input type="text" class="form-control" id="location" name="location" 
                                           value="<?= htmlspecialchars($event['location']) ?>">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="published" <?= $event['status'] == 'published' ? 'selected' : '' ?>>Published</option>
                                        <option value="draft" <?= $event['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
                                        <option value="cancelled" <?= $event['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Update Event</button>
                                <a href="Dashboard.php" class="btn btn-secondary">Kembali</a>
                                <?php if ($_SESSION['role'] == 'admin'): ?>
                                    <button type="button" class="btn btn-danger float-end" id="btnDelete">Hapus Event</button>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
            
            <?php include 'footer.php'; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi datetime picker
            flatpickr("#start_datetime", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true
            });
            
            flatpickr("#end_datetime", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true
            });
            
            // Validasi form
            $("#eventForm").submit(function(e) {
                var start = new Date($("#start_datetime").val());
                var end = new Date($("#end_datetime").val());
                
                if (start >= end) {
                    alert("Waktu selesai harus setelah waktu mulai");
                    e.preventDefault();
                }
            });
            
            // Tombol hapus
            $("#btnDelete").click(function() {
                if (confirm("Apakah Anda yakin ingin menghapus event ini?")) {
                    window.location.href = "delete_event.php?id=<?= $event['id'] ?>";
                }
            });
        });
    </script>
</body>
</html>