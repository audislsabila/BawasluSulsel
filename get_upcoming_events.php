<?php
require 'function.php';
require 'cek.php';

header('Content-Type: application/json');

if (!isset($_SESSION['log'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Ambil 5 event terdekat dalam 30 hari ke depan dengan informasi pembuat
$query = "SELECT e.id, e.title, e.description, e.start_datetime, e.end_datetime, 
          e.location, e.status, u.name as creator_name
          FROM events e
          LEFT JOIN users u ON e.created_by = u.id
          WHERE e.status = 'published' 
          AND e.start_datetime BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY)
          ORDER BY e.start_datetime ASC 
          LIMIT 5";

$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
    exit;
}

$events = [];
while ($row = mysqli_fetch_assoc($result)) {
    $events[] = $row;
}

echo json_encode([
    'success' => true,
    'data' => $events,
    'generated_at' => date('Y-m-d H:i:s')
]);
?>