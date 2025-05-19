<?php
require 'function.php';
require 'cek.php';

header('Content-Type: application/json');

$response = ['success' => false, 'data' => []];

try {
    $online_users = get_online_users($conn);
    $response['data'] = $online_users;
    $response['success'] = true;
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
?>