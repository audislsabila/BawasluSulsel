<?php
require 'function.php';

// Cek jika form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cek aksi yang dilakukan
    if (isset($_POST['addkehadiran'])) {
        // Validasi input
        $judul = clean_input($_POST['judul'] ?? '');
        $tanggal = clean_input($_POST['tanggal'] ?? '');
        
        if (empty($judul) || empty($tanggal)) {
            show_alert('Judul dan tanggal harus diisi', 'danger');
            redirect('Kehadiran.php');
        }
        
        // Upload dokumen (PDF/DOC/DOCX)
        $doc_upload = upload_file(
            $_FILES['file_path'] ?? null,
            'uploads/documents/',
            ['pdf', 'doc', 'docx']
        );
        
        // Upload gambar (JPG/PNG)
        $img_upload = upload_file(
            $_FILES['file_name'] ?? null,
            'uploads/images/',
            ['jpg', 'jpeg', 'png']
        );
        
        // Cek hasil upload
        if (!$doc_upload['success'] || !$img_upload['success']) {
            $error_msg = '';
            if (!$doc_upload['success']) $error_msg .= 'Dokumen: ' . $doc_upload['message'] . ' ';
            if (!$img_upload['success']) $error_msg .= 'Gambar: ' . $img_upload['message'];
            show_alert($error_msg, 'danger');
            redirect('Kehadiran.php');
        }
        
        // Insert ke database
        $stmt = $conn->prepare("INSERT INTO laporan_kehadiran (judul, tanggal, file_path, file_name) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $judul, $tanggal, $doc_upload['file_path'], $img_upload['file_path']);
        
        if ($stmt->execute()) {
            show_alert('Data berhasil ditambahkan', 'success');
        } else {
            // Hapus file yang sudah terupload jika gagal insert
            if (file_exists($doc_upload['file_path'])) unlink($doc_upload['file_path']);
            if (file_exists($img_upload['file_path'])) unlink($img_upload['file_path']);
            show_alert('Gagal menyimpan data: ' . $conn->error, 'danger');
        }
        $stmt->close();
        
        redirect('Kehadiran.php');
    }
    
    // Handle edit kehadiran
    if (isset($_POST['editkehadiran'])) {
        $id_kehadiran = clean_input($_POST['id_kehadiran'] ?? '');
        $judul = clean_input($_POST['judul'] ?? '');
        $tanggal = clean_input($_POST['tanggal'] ?? '');
        
        if (empty($id_kehadiran) || empty($judul) || empty($tanggal)) {
            show_alert('ID, judul dan tanggal harus diisi', 'danger');
            redirect('Kehadiran.php');
        }
        
        // Ambil data lama untuk file paths
        $stmt = $conn->prepare("SELECT file_path, file_name FROM laporan_kehadiran WHERE id_kehadiran = ?");
        $stmt->bind_param("i", $id_kehadiran);
        $stmt->execute();
        $result = $stmt->get_result();
        $old_data = $result->fetch_assoc();
        $stmt->close();
        
        $file_path = $old_data['file_path'];
        $file_name = $old_data['file_name'];
        
        // Handle file upload dokumen jika ada
        if (!empty($_FILES['file_path']['name'])) {
            $doc_upload = upload_file(
                $_FILES['file_path'],
                'uploads/documents/',
                ['pdf', 'doc', 'docx']
            );
            
            if ($doc_upload['success']) {
                // Hapus file lama jika ada
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
                $file_path = $doc_upload['file_path'];
            } else {
                show_alert('Gagal upload dokumen: ' . $doc_upload['message'], 'danger');
                redirect('Kehadiran.php');
            }
        }
        
        // Handle file upload gambar jika ada
        if (!empty($_FILES['file_name']['name'])) {
            $img_upload = upload_file(
                $_FILES['file_name'],
                'uploads/images/',
                ['jpg', 'jpeg', 'png']
            );
            
            if ($img_upload['success']) {
                // Hapus file lama jika ada
                if (file_exists($file_name)) {
                    unlink($file_name);
                }
                $file_name = $img_upload['file_path'];
            } else {
                show_alert('Gagal upload gambar: ' . $img_upload['message'], 'danger');
                redirect('Kehadiran.php');
            }
        }
        
        // Update data di database
        $stmt = $conn->prepare("UPDATE laporan_kehadiran SET judul = ?, tanggal = ?, file_path = ?, file_name = ? WHERE id_kehadiran = ?");
        $stmt->bind_param("ssssi", $judul, $tanggal, $file_path, $file_name, $id_kehadiran);
        
        if ($stmt->execute()) {
            show_alert('Data berhasil diupdate', 'success');
        } else {
            show_alert('Gagal mengupdate data: ' . $conn->error, 'danger');
        }
        $stmt->close();
        
        redirect('Kehadiran.php');
    }
    
    // Handle delete kehadiran
    if (isset($_POST['hapuskehadiran'])) {
        $id_kehadiran = clean_input($_POST['id_kehadiran'] ?? '');
        
        if (empty($id_kehadiran)) {
            show_alert('ID harus diisi', 'danger');
            redirect('Kehadiran.php');
        }
        
        // Ambil data untuk menghapus file terkait
        $stmt = $conn->prepare("SELECT file_path, file_name FROM laporan_kehadiran WHERE id_kehadiran = ?");
        $stmt->bind_param("i", $id_kehadiran);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        
        // Hapus data dari database
        $stmt = $conn->prepare("DELETE FROM laporan_kehadiran WHERE id_kehadiran = ?");
        $stmt->bind_param("i", $id_kehadiran);
        
        if ($stmt->execute()) {
            // Hapus file terkait jika ada
            if (file_exists($data['file_path'])) {
                unlink($data['file_path']);
            }
            if (file_exists($data['file_name'])) {
                unlink($data['file_name']);
            }
            show_alert('Data berhasil dihapus', 'success');
        } else {
            show_alert('Gagal menghapus data: ' . $conn->error, 'danger');
        }
        $stmt->close();
        
        redirect('Kehadiran.php');
    }
}

redirect('Kehadiran.php');
?>