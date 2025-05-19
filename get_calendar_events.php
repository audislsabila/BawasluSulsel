<?php
require 'function.php';
require 'cek.php';

header('Content-Type: application/json');

if (!isset($_SESSION['log'])) {
    echo json_encode([]);
    exit;
}

$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;

$query = "SELECT id, title, start_datetime as start, end_datetime as end, 
          description, location, status 
          FROM events 
          WHERE status = 'published' 
          ORDER BY start_datetime ASC";

$result = mysqli_query($conn, $query);
$events = [];

while ($row = mysqli_fetch_assoc($result)) {
    $events[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'start' => $row['start'],
        'end' => $row['end'],
        'description' => $row['description'],
        'location' => $row['location'],
        'status' => $row['status'],
        'color' => getEventColor($row['status'], $row['start'], $row['end'])
    ];
}

function getEventColor($status, $start, $end) {
    $now = new DateTime();
    $start_date = new DateTime($start);
    $end_date = new DateTime($end);
    
    if ($status == 'cancelled') {
        return '#6c757d'; // Abu-abu untuk event yang dibatalkan
    } elseif ($now > $end_date) {
        return '#28a745'; // Hijau untuk event yang sudah selesai
    } elseif ($now >= $start_date && $now <= $end_date) {
        return '#17a2b8'; // Biru untuk event yang sedang berlangsung
    } else {
        return '#007bff'; // Biru tua untuk event mendatang
    }
}

echo json_encode($events);
?>