<?php
require 'function.php';

$data = [
    'statusAktif' => 0,
    'totalAnggota' => 0,
    'totalPengguna' => 0
];

$query = "SELECT 
    SUM(CASE WHEN status_pegawai = 'Aktif' THEN 1 ELSE 0 END) as statusAktif,
    COUNT(*) as totalAnggota 
    FROM basis_data";
$result = mysqli_query($conn, $query);
if($result) {
    $row = mysqli_fetch_assoc($result);
    $data['statusAktif'] = $row['statusAktif'];
    $data['totalAnggota'] = $row['totalAnggota'];
}

$queryPengguna = "SELECT COUNT(*) as total FROM users";
$resultPengguna = mysqli_query($conn, $queryPengguna);
if($resultPengguna) {
    $data['totalPengguna'] = mysqli_fetch_assoc($resultPengguna)['total'];
}

echo json_encode($data);
?>