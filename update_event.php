<?php
require 'function.php';
require 'cek.php';

if (!isset($_SESSION['log'])) {
    header("Location: Login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_id = intval($_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $start_datetime = mysqli_real_escape_string($conn, $_POST['start_datetime']);
    $end_datetime = mysqli_real_escape_string($conn, $_POST['end_datetime']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Validasi waktu
    if (strtotime($end_datetime) <= strtotime($start_datetime)) {
        $_SESSION['error'] = "Waktu selesai harus setelah waktu mulai";
        header("Location: edit_event.php?id=$event_id");
        exit;
    }

    // Periksa apakah user memiliki hak untuk mengedit
    $check_query = "SELECT created_by FROM events WHERE id = $event_id";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) == 0) {
        $_SESSION['error'] = "Event tidak ditemukan";
        header("Location: Dashboard.php");
        exit;
    }
    
    $event = mysqli_fetch_assoc($check_result);
    
    if ($_SESSION['id'] != $event['created_by'] && $_SESSION['role'] != 'admin') {
        $_SESSION['error'] = "Anda tidak memiliki hak untuk mengedit event ini";
        header("Location: Dashboard.php");
        exit;
    }

    // Update event
    $query = "UPDATE events SET 
              title = '$title',
              description = '$description',
              start_datetime = '$start_datetime',
              end_datetime = '$end_datetime',
              location = '$location',
              status = '$status'
              WHERE id = $event_id";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Event berhasil diperbarui";
    } else {
        $_SESSION['error'] = "Gagal memperbarui event: " . mysqli_error($conn);
    }
    
    header("Location: Dashboard.php");
    exit;
} else {
    header("Location: Dashboard.php");
    exit;
}
?>