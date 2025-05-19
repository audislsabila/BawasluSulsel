<?php
require 'function.php';

// Contoh untuk mengirim notifikasi saat surat baru dibuat
function sendNewLetterNotification($conn, $letterId, $letterTitle, $senderId) {
    // Dapatkan semua admin/user yang perlu diberi notifikasi
    $query = $conn->query("SELECT id_login FROM login WHERE role IN ('admin', 'user')");
    
    while ($user = $query->fetch_assoc()) {
        if ($user['id_login'] != $senderId) { // Jangan kirim ke diri sendiri
            $message = "Surat baru: " . $letterTitle;
            $link = "view_letter.php?id=" . $letterId;
            createNotification($conn, $senderId, $user['id_login'], 'new_letter', $message, $link);
        }
    }
}

// Contoh untuk mengirim notifikasi saat agenda rapat baru dibuat
function sendNewMeetingNotification($conn, $meetingId, $meetingTitle, $senderId) {
    // Dapatkan semua admin/user yang perlu diberi notifikasi
    $query = $conn->query("SELECT id_login FROM login WHERE role IN ('admin', 'user')");
    
    while ($user = $query->fetch_assoc()) {
        if ($user['id_login'] != $senderId) {
            $message = "Agenda rapat baru: " . $meetingTitle;
            $link = "view_meeting.php?id=" . $meetingId;
            createNotification($conn, $senderId, $user['id_login'], 'new_meeting', $message, $link);
        }
    }
}