<?php
require 'function.php';
require 'cek.php';

if(isset($_GET['file'])) {
    $filepath = urldecode($_GET['file']);
    
    if(file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
        exit;
    }
}
header("Location: agenda_rapat.php");
exit;
?>