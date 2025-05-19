<?php
require 'function.php';

session_start();

if (!isset($_SESSION['id_user'])) {
    echo json_encode(['success' => false]);
    exit;
}

$unreadCount = count(getUnreadNotifications($conn, $_SESSION['id_user']));
echo json_encode(['success' => true, 'count' => $unreadCount]);