<?php
require 'function.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $notificationId = $_POST['id'];
    markAsRead($conn, $notificationId);
    
    echo json_encode(['success' => true]);
    exit;
}

echo json_encode(['success' => false]);