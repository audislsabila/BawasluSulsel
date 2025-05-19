<?php 
$host = "localhost";
$user = "root";
$password = "";
$database = "bawaslusulsel";
session_start();


// Membuat koneksi ke database
$conn = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set timezone sesuai kebutuhan
date_default_timezone_set('Asia/Makassar');

function checkSessionAndRedirect() {
    if (isset($_SESSION['log'])) {
        // Redirect berdasarkan role
        switch($_SESSION['role']) {
            case 'admin':
                header("Location: Dashboard.php");
                break;
            case 'user':
                header("Location: DashboardUser.php");
                break;
            default:
                header("Location: DashboardKetua.php");
        }
        exit;
    }
}

function processLogin($conn) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Gunakan prepared statement
    $stmt = $conn->prepare("SELECT * FROM login WHERE email = ?");
    if (!$stmt) {
        die("Prepare statement failed: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika data ditemukan
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password (plain text comparison)
        if ($password === $user['password']) {
            $_SESSION['log'] = true;
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['id_user'] = $user['id_login'];

            // Redirect berdasarkan role
            switch($user['role']) {
                case 'admin':
                    header("Location: Dashboard.php");
                    break;
                case 'user':
                    header("Location: DashboardUser.php");
                    break;
                default:
                    header("Location: DashboardKetua.php");
            }
            exit();
        } else {
            // Password tidak match
            return "error=1";
        }
    } else {
        // Email tidak ditemukan
        return "error=1";
    }
    return "";
}


// Fungsi untuk menampilkan alert jika ada
function display_alert() {
    if (isset($_SESSION['alert'])) {
        $alert = $_SESSION['alert'];
        echo '<div class="alert alert-'.$alert['type'].' alert-dismissible fade show" role="alert">
                '.$alert['message'].'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
        unset($_SESSION['alert']);
    }
}

// Fungsi untuk redirect
function redirect($url) {
    header("Location: " . $url);
    exit();
}

// Proses upload file dan simpan data surat
if(isset($_POST['addsurat'])){
    $jenis_surat = $_POST['jenis_surat'];
    $tanggal = $_POST['tanggal'];
    $pengirim = $_POST['pengirim'];
    $penerima = $_POST['penerima'];
    
    // Handle file upload
    $target_dir = "uploads/surat/";
    if(!file_exists($target_dir)){
        mkdir($target_dir, 0777, true);
    }
    
    $file_name = basename($_FILES["file_path"]["name"]);
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Check if file already exists
    if (file_exists($target_file)) {
        $_SESSION['error'] = "Maaf, file sudah ada.";
        $uploadOk = 0;
    }
    
    // Check file size (max 5MB)
    if ($_FILES["file_path"]["size"] > 5000000) {
        $_SESSION['error'] = "Maaf, ukuran file terlalu besar (max 5MB).";
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($fileType != "pdf" && $fileType != "doc" && $fileType != "docx") {
        $_SESSION['error'] = "Maaf, hanya file PDF, DOC, dan DOCX yang diperbolehkan.";
        $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $_SESSION['error'] = "Maaf, file Anda tidak terupload.";
    } else {
        // if everything is ok, try to upload file
        if (move_uploaded_file($_FILES["file_path"]["tmp_name"], $target_file)) {
            // Insert data ke database
            $insert = mysqli_query($conn, "INSERT INTO surat (jenis_surat, tanggal, pengirim, penerima, file_path) 
                                          VALUES ('$jenis_surat', '$tanggal', '$pengirim', '$penerima', '$target_file')");
            
            if($insert){
                $_SESSION['success'] = "Surat berhasil ditambahkan!";
            } else {
                $_SESSION['error'] = "Gagal menyimpan data ke database: " . mysqli_error($conn);
                // Hapus file yang sudah terupload jika gagal insert ke database
                unlink($target_file);
            }
        } else {
            $_SESSION['error'] = "Maaf, terjadi kesalahan saat mengupload file.";
        }
    }
    
    header("location: surat.php");
    exit();
}

// Proses Delete Surat
if (isset($_POST['Hapussurat'])) {
    $id = $_POST['id_surat'];
    $delete = mysqli_query($conn, "DELETE FROM surat WHERE id_surat='$id'");
    if ($delete) {
        header('Location: Surat.php');
    } else {
        echo "Gagal menghapus data";
    }
}

// Proses update surat
if(isset($_POST['updatesurat'])){
    $id_surat = $_POST['id_surat'];
    $jenis_surat = $_POST['jenis_surat'];
    $tanggal = $_POST['tanggal'];
    $pengirim = $_POST['pengirim'];
    $penerima = $_POST['penerima'];
    
    // Ambil data file lama
    $query = mysqli_query($conn, "SELECT file_path FROM surat WHERE id_surat = '$id_surat'");
    $data = mysqli_fetch_array($query);
    $old_file = $data['file_path'];
    
    // Handle file upload jika ada file baru
    if(!empty($_FILES["file_path"]["name"])){
        $target_dir = "uploads/surat/";
        $file_name = basename($_FILES["file_path"]["name"]);
        $target_file = $target_dir . $file_name;
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        // Validasi file sama seperti di atas
        if (file_exists($target_file)) {
            $_SESSION['error'] = "Maaf, file sudah ada.";
            $uploadOk = 0;
        }
        
        if ($_FILES["file_path"]["size"] > 5000000) {
            $_SESSION['error'] = "Maaf, ukuran file terlalu besar (max 5MB).";
            $uploadOk = 0;
        }
        
        if($fileType != "pdf" && $fileType != "doc" && $fileType != "docx") {
            $_SESSION['error'] = "Maaf, hanya file PDF, DOC, dan DOCX yang diperbolehkan.";
            $uploadOk = 0;
        }
        
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["file_path"]["tmp_name"], $target_file)) {
                // Hapus file lama
                if(file_exists($old_file)){
                    unlink($old_file);
                }
                // Update database dengan file baru
                $update = mysqli_query($conn, "UPDATE surat SET 
                    jenis_surat = '$jenis_surat', 
                    tanggal = '$tanggal', 
                    pengirim = '$pengirim', 
                    penerima = '$penerima', 
                    file_path = '$target_file' 
                    WHERE id_surat = '$id_surat'");
            } else {
                $_SESSION['error'] = "Maaf, terjadi kesalahan saat mengupload file.";
            }
        }
    } else {
        // Update tanpa mengganti file
        $update = mysqli_query($conn, "UPDATE surat SET 
            jenis_surat = '$jenis_surat', 
            tanggal = '$tanggal', 
            pengirim = '$pengirim', 
            penerima = '$penerima' 
            WHERE id_surat = '$id_surat'");
    }
    
    if($update){
        $_SESSION['success'] = "Surat berhasil diupdate!";
    } else {
        $_SESSION['error'] = "Gagal mengupdate surat: " . mysqli_error($conn);
    }
    
    header("location: surat.php");
    exit();
}

// Proses Tambah Dokumen
if (isset($_POST['adddokumen'])) {
    $jenis_dokumen = $_POST['jenis_dokumen'];
    $divisi = $_POST['divisi'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];


    if (empty($tanggal) || $tanggal == '0000-00-00') {
        echo "<script>alert('Tanggal tidak boleh kosong.');</script>";
        exit;
    }

    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = basename($_FILES["file_path"]["name"]);
    $target_file = $target_dir . $file_name;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $allowedTypes = array('pdf', 'doc', 'docx');
    if (!in_array($fileType, $allowedTypes)) {
        echo "<script>alert('Hanya file PDF, DOC, dan DOCX yang diizinkan.');</script>";
    } else {
        if (move_uploaded_file($_FILES["file_path"]["tmp_name"], $target_file)) {
            $insert = mysqli_query($conn, "INSERT INTO administrasi (jenis_dokumen, divisi, tanggal, waktu, file_path) 
                                           VALUES ('$jenis_dokumen', '$divisi', '$tanggal', '$waktu', '$target_file')");
            if ($insert) {
                header("Location: administrasi_user.php");

                echo "<script>alert('Gagal menambahkan dokumen.');</script>";
            }
        } else {
            echo "<script>alert('Gagal mengupload file.');</script>";
        }
    }
}


if (isset($_POST['updatedokumen'])) {
    $id_dokumen = $_POST['id_dokumen'];
    $jenis_dokumen = $_POST['jenis_dokumen'];
    $divisi = $_POST['divisi'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];

    
    // Handle file update if a new file is uploaded
    if (!empty($_FILES["file_path"]["name"])) {
        $target_dir = "uploads/";
        $file_name = basename($_FILES["file_path"]["name"]);
        $target_file = $target_dir . $file_name;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        $allowedTypes = array('pdf', 'doc', 'docx');
        if (!in_array($fileType, $allowedTypes)) {
            echo "<script>alert('Hanya file PDF, DOC, dan DOCX yang diizinkan.');</script>";
        } else {
            if (move_uploaded_file($_FILES["file_path"]["tmp_name"], $target_file)) {
                $update = mysqli_query($conn, "UPDATE administrasi SET 
                    jenis_dokumen='$jenis_dokumen', 
                    divisi='$divisi', 
                    tanggal='$tanggal', 
                    waktu='$waktu', 
                    file_path='$target_file' 
                    WHERE id_dokumen='$id_dokumen'");
                
                if ($update) {
                    header("Location: administrasi_user.php");
                } else {
                    echo "<script>alert('Gagal mengupdate dokumen.');</script>";
                }
            } else {
                echo "<script>alert('Gagal mengupload file baru.');</script>";
            }
        }
    } else {
        // Update without changing the file
        $update = mysqli_query($conn, "UPDATE administrasi SET 
            jenis_dokumen='$jenis_dokumen', 
            divisi='$divisi', 
            tanggal='$tanggal',
            waktu='$waktu' 
            WHERE id_dokumen='$id_dokumen'");
        
        if ($update) {
            header("Location: administrasi_user.php");
        } else {
            echo "<script>alert('Gagal mengupdate dokumen.');</script>";
        }
    }
}

if (isset($_POST['Hapusdokumen'])) {
    $id_dokumen = $_POST['id_dokumen'];
    
    // Get file path before deleting
    $query = mysqli_query($conn, "SELECT file_path FROM administrasi WHERE id_dokumen='$id_dokumen'");
    $data = mysqli_fetch_array($query);
    $file_path = $data['file_path'];
    
    // Delete the record
    $delete = mysqli_query($conn, "DELETE FROM administrasi WHERE id_dokumen='$id_dokumen'");
    
    if ($delete) {
        // Delete the file
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        header("Location: administrasi_user.php");
    } else {
        echo "<script>alert('Gagal menghapus dokumen.');</script>";
    }
}

// FUNGSI UPLOAD FOTO YANG DIPERBAIKI
function uploadFoto($file) {
    $targetDir = "uploads/";
    
    // Membuat folder jika belum ada
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0755, true); // Gunakan 0755 untuk permission yang lebih aman
    }
    
    // Generate nama file unik untuk menghindari overwrite
    $fileName = uniqid() . '_' . basename($file["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION)); // Convert ke lowercase

    // Cek apakah file adalah gambar
    $check = getimagesize($file["tmp_name"]);
    if($check === false) {
        return ['error' => 'File bukan gambar yang valid'];
    }

    // Cek ukuran file (max 2MB)
    if ($file["size"] > 2000000) {
        return ['error' => 'Ukuran file melebihi 2MB'];
    }

    // Format file yang diizinkan
    $allowTypes = ['jpg','png','jpeg','gif'];
    if(!in_array($fileType, $allowTypes)){
        return ['error' => 'Format file tidak didukung'];
    }

    // Upload file
    if(move_uploaded_file($file["tmp_name"], $targetFilePath)) {
        return ['success' => $fileName];
    }
    return ['error' => 'Gagal mengupload file'];
}

// FUNGSI TAMBAH DATA YANG DIPERBAIKI
if(isset($_POST['addbasisdata'])){
    // Handle upload foto
    $uploadResult = uploadFoto($_FILES["foto"]);
    
    if(isset($uploadResult['error'])) {
        echo "<script>alert('Error: ".$uploadResult['error']."'); window.history.back();</script>";
        exit;
    }
    
    try {
        $stmt = $conn->prepare("INSERT INTO basis_data (
            nip, 
            nama_lengkap, 
            jabatan, 
            divisi, 
            no_hp, 
            email, 
            alamat, 
            tanggal_lahir, 
            tanggal_masuk,  
            foto
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        // Sanitize input data
        $nip = htmlspecialchars($_POST['nip']);
        $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
        $jabatan = htmlspecialchars($_POST['jabatan']);
        $divisi = htmlspecialchars($_POST['divisi']);
        $no_hp = htmlspecialchars($_POST['no_hp']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $alamat = htmlspecialchars($_POST['alamat']);
        $tanggal_lahir = $_POST['tanggal_lahir'];
        $tanggal_masuk = $_POST['tanggal_masuk'];
        $foto = $uploadResult['success'];
        
        $stmt->bind_param("ssssssssss",
            $nip,
            $nama_lengkap,
            $jabatan,
            $divisi,
            $no_hp,
            $email,
            $alamat,
            $tanggal_lahir,
            $tanggal_masuk,
            $foto
        );
        
        if($stmt->execute()) {
            header("Location: Basis_data.php?success=1");
            exit;
        } else {
            throw new Exception("Gagal menyimpan data ke database: " . $stmt->error);
        }
        
    } catch(Exception $e) {
        // Hapus file yang sudah terupload jika gagal insert database
        if(isset($foto) && file_exists("uploads/".$foto)) {
            unlink("uploads/".$foto);
        }
        echo "<script>alert('".$e->getMessage()."'); window.history.back();</script>";
    } finally {
        if(isset($stmt)) {
            $stmt->close();
        }
    }
}

// FUNGSI UPDATE DATA
if(isset($_POST['updatebasisdata'])){
    // Ambil data dari form
    $id_anggota = $_POST['id_anggota'];
    $nip = htmlspecialchars($_POST['nip']);
    $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
    $jabatan = htmlspecialchars($_POST['jabatan']);
    $divisi = htmlspecialchars($_POST['divisi']);
    $no_hp = htmlspecialchars($_POST['no_hp']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $alamat = htmlspecialchars($_POST['alamat']);
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $foto_lama = $_POST['foto_lama'];
    
    // Handle upload foto baru
    $foto = $foto_lama;
    if(!empty($_FILES["foto"]["name"])) {
        $uploadResult = uploadFoto($_FILES["foto"]);
        
        if(isset($uploadResult['error'])) {
            echo "<script>
                alert('Error: ".$uploadResult['error']."');
                window.location.href = 'Basis_data.php';
            </script>";
            exit;
        }
        
        // Jika upload foto baru berhasil, hapus foto lama jika ada
        if(!empty($foto_lama) && file_exists("uploads/".$foto_lama)) {
            unlink("uploads/".$foto_lama);
        }
        $foto = $uploadResult['success'];
    }

    try {
        $stmt = $conn->prepare("UPDATE basis_data SET 
            nip = ?,
            nama_lengkap = ?,
            jabatan = ?,
            divisi = ?,
            no_hp = ?,
            email = ?,
            alamat = ?,
            tanggal_lahir = ?,
            tanggal_masuk = ?,
            foto = ?
            WHERE id_anggota = ?");
            
        if(!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
            
        $stmt->bind_param("ssssssssssi",
            $nip,
            $nama_lengkap,
            $jabatan,
            $divisi,
            $no_hp,
            $email,
            $alamat,
            $tanggal_lahir,
            $tanggal_masuk,
            $foto,
            $id_anggota
        );
        
        if($stmt->execute()) {
            echo "<script>
                alert('Data berhasil diupdate');
                window.location.href = 'Basis_data.php';
            </script>";
        } else {
            throw new Exception("Gagal update data: " . $stmt->error);
        }
        
    } catch(Exception $e) {
        // Hapus file yang baru diupload jika ada error
        if(isset($uploadResult['success']) && file_exists("uploads/".$uploadResult['success'])) {
            unlink("uploads/".$uploadResult['success']);
        }
        echo "<script>
            alert('".addslashes($e->getMessage())."');
            window.history.back();
        </script>";
    } finally {
        if(isset($stmt)) {
            $stmt->close();
        }
    }
}

// FUNGSI HAPUS DATA YANG DIPERBAIKI
if(isset($_POST['hapusbasisdata'])){
    $id_anggota = $_POST['id_anggota'];
    
    try {
        // Ambil data foto
        $get_foto = $conn->prepare("SELECT foto FROM basis_data WHERE id_anggota = ?");
        $get_foto->bind_param("i", $id_anggota);
        $get_foto->execute();
        $result = $get_foto->get_result();
        
        if($result->num_rows == 0) {
            throw new Exception("Data tidak ditemukan");
        }
        
        $data = $result->fetch_assoc();
        $foto = $data['foto'];
        
        // Hapus data dari database
        $stmt = $conn->prepare("DELETE FROM basis_data WHERE id_anggota = ?");
        $stmt->bind_param("i", $id_anggota);
        
        if($stmt->execute()) {
            // Hapus file foto jika ada
            if(!empty($foto) ){
                $file_path = "uploads/".$foto;
                if(file_exists($file_path)) {
                    if(!unlink($file_path)) {
                        throw new Exception("Gagal menghapus file foto");
                    }
                }
            }
            
            header("Location: Basis_data.php?success=delete");
            exit;
        } else {
            throw new Exception("Gagal menghapus data: " . $stmt->error);
        }
        
    } catch(Exception $e) {
        echo "<script>
            alert('".addslashes($e->getMessage())."');
            window.location.href = 'Basis_data.php';
        </script>";
    } finally {
        if(isset($stmt)) $stmt->close();
        if(isset($get_foto)) $get_foto->close();
    }
}

if (isset($_POST['addrapat'])) {
    $judul = $_POST['judul'];
    $tanggal = $_POST['tanggal'];
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];
    $tempat = $_POST['tempat'];
    $pimpinan = $_POST['pimpinan'];
    $notulen = $_POST['notulen'];
    $peserta = $_POST['peserta'];
    $agenda = $_POST['agenda'];
    $status = $_POST['status'];
    
  
    // Handle File Upload
    $dokumen_path = '';
    if($_FILES['dokumen']['name'] != "") {
        $targetDir = "uploads/agenda/";
        if(!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        $fileName = time().'_'.basename($_FILES['dokumen']['name']);
        $targetFile = $targetDir . $fileName;
        
        // File validation
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = array('pdf', 'doc', 'docx');
        
        if(in_array($fileType, $allowedTypes)) {
            if(move_uploaded_file($_FILES['dokumen']['tmp_name'], $targetFile)) {
                $dokumen_path = $targetFile;
            }
        }
    }
    $insert = mysqli_query($conn, "INSERT INTO agenda_rapat (judul_rapat, tanggal, waktu_mulai, waktu_selesai, tempat, pemimpinan_rapat, notulen, peserta, agenda, dokumen_path, status) 
                VALUES ('$judul', '$tanggal', '$waktu_mulai', '$waktu_selesai', '$tempat', '$pimpinan', '$notulen', '$peserta', '$agenda', '$dokumen_path', '$status')");
    
    if ($insert) {
        header('Location: agenda_rapat.php');
    } else {
        echo '<script>alert("Gagal menambahkan agenda rapat");</script>';
    }
}

// UPDATE AGENDA
if(isset($_POST['updaterapat'])){
    $id_rapat = $_POST['id_rapat'];
    $judul = $_POST['judul'];
    $tanggal = $_POST['tanggal'];
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];
    $tempat = $_POST['tempat'];
    $pimpinan = $_POST['pimpinan'];
    $notulen = $_POST['notulen'];
    $peserta = $_POST['peserta'];
    $agenda = $_POST['agenda'];
    $status = $_POST['status'];
    $existing_file = $_POST['existing_file'];
    
    // File handling
    $dokumen_path = $existing_file;
    
    // Jika checkbox hapus file dicentang
    if(isset($_POST['hapus_file']) && $_POST['hapus_file'] == 'on'){
        if(file_exists($existing_file)){
            unlink($existing_file);
        }
        $dokumen_path = '';
    }
    
    // Jika upload file baru
    if($_FILES['dokumen']['name'] != ''){
        $allowed = array('pdf','doc','docx');
        $filename = $_FILES['dokumen']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        
        if(in_array($ext, $allowed)){
            // Hapus file lama jika ada
            if($dokumen_path != '' && file_exists($dokumen_path)){
                unlink($dokumen_path);
            }
            
            // Upload file baru
            $upload_dir = 'uploads/agenda/';
            if(!is_dir($upload_dir)){
                mkdir($upload_dir, 0777, true);
            }
            
            $new_filename = uniqid().'.'.$ext;
            $dokumen_path = $upload_dir.$new_filename;
            move_uploaded_file($_FILES['dokumen']['tmp_name'], $dokumen_path);
        } else {
            echo "<script>alert('Format file tidak didukung');</script>";
            exit();
        }
    }
    
    // Update database
    $stmt = $conn->prepare("UPDATE agenda_rapat SET 
        judul_rapat = ?,
        tanggal = ?,
        waktu_mulai = ?,
        waktu_selesai = ?,
        tempat = ?,
        pemimpinan_rapat = ?,
        notulen = ?,
        peserta = ?,
        agenda = ?,
        status = ?,
        dokumen_path = ?
        WHERE id_rapat = ?");
        
    $stmt->bind_param("sssssssssssi",
        $judul,
        $tanggal,
        $waktu_mulai,
        $waktu_selesai,
        $tempat,
        $pimpinan,
        $notulen,
        $peserta,
        $agenda,
        $status,
        $dokumen_path,
        $id_rapat);
    
    if($stmt->execute()){
        header('Location: agenda_rapat.php');
    } else {
        echo "<script>alert('Gagal mengupdate data');</script>";
    }
    
    $stmt->close();
}

// Kode Hapus Agenda Rapat
if(isset($_POST['HapusRapat'])){
    $id_rapat = $_POST['id_rapat'];
    
    // Ambil path dokumen
    $fetch = mysqli_query($conn, "SELECT dokumen_path FROM agenda_rapat WHERE id_rapat = '$id_rapat'");
    $data = mysqli_fetch_assoc($fetch);
    $dokumen_path = $data['dokumen_path'];
    
    // Hapus file jika ada
    if($dokumen_path != '' && file_exists($dokumen_path)){
        unlink($dokumen_path);
    }
    
    // Hapus dari database
    $delete = mysqli_query($conn, "DELETE FROM agenda_rapat WHERE id_rapat = '$id_rapat'");
    
    if($delete){
        header('Location: agenda_rapat.php');
    } else {
        echo "<script>alert('Gagal menghapus agenda rapat');</script>";
        echo "<script>window.location.href = 'agenda_rapat.php';</script>";
    }
}
// Tampilkan pesan sukses
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}

// Tampilkan pesan error
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}



if (isset($_POST['addkehadiran'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    
    // Direktori penyimpanan file
    $uploadDir = "uploads/kehadiran/";
    
    // Cek dan buat folder jika belum ada
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Handle document upload
    $docFile = $_FILES['file_path'];
    $docFileName = basename($docFile['name']);
    $docTargetPath = $uploadDir . uniqid() . '_' . $docFileName;
    $docFileType = strtolower(pathinfo($docTargetPath, PATHINFO_EXTENSION));
    
    // Handle image upload
    $imgFile = $_FILES['file_name'];
    $imgFileName = basename($imgFile['name']);
    $imgTargetPath = $uploadDir . uniqid() . '_' . $imgFileName;
    $imgFileType = strtolower(pathinfo($imgTargetPath, PATHINFO_EXTENSION));

    // Validasi file dokumen
    $allowedDocs = ['pdf', 'doc', 'docx'];
    if (!in_array($docFileType, $allowedDocs)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'Hanya file PDF, DOC, dan DOCX yang diperbolehkan untuk dokumen.'
        ];
        header("Location: Kehadiran.php");
        exit();
    }

    // Validasi file gambar
    $allowedImgs = ['jpg', 'jpeg', 'png'];
    if (!in_array($imgFileType, $allowedImgs)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'Hanya file JPG, JPEG, dan PNG yang diperbolehkan untuk gambar.'
        ];
        header("Location: Kehadiran.php");
        exit();
    }

    // Coba upload file
    if (move_uploaded_file($docFile['tmp_name'], $docTargetPath) && 
        move_uploaded_file($imgFile['tmp_name'], $imgTargetPath)) {
        
        // Simpan ke database
        $query = "INSERT INTO laporan_kehadiran 
                  (judul, tanggal, file_path, file_name) 
                  VALUES ('$judul', '$tanggal', '$docTargetPath', '$imgTargetPath')";
        
        if (mysqli_query($conn, $query)) {
            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => 'Data kehadiran berhasil ditambahkan!'
            ];
        } else {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'message' => 'Gagal menyimpan data ke database: ' . mysqli_error($conn)
            ];
        }
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'Gagal mengupload file!'
        ];
    }

    header("Location: Kehadiran.php");
    exit();
}


if (isset($_POST['editkehadiran'])) {
    $id_kehadiran = $_POST['id_kehadiran'];
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);

    // Ambil data lama
    $getData = mysqli_query($conn, "SELECT * FROM laporan_kehadiran WHERE id_kehadiran = '$id_kehadiran'");
    $oldData = mysqli_fetch_assoc($getData);
    
    $uploadDir = "uploads/kehadiran/";
    $currentDoc = $oldData['file_path'];
    $currentImg = $oldData['file_name'];

    // Update dokumen jika ada file baru
    if ($_FILES['file_path']['name'] != "") {
        $docFile = $_FILES['file_path'];
        $docExt = strtolower(pathinfo($docFile['name'], PATHINFO_EXTENSION));
        $allowedDoc = ['pdf', 'doc', 'docx'];
        
        if (in_array($docExt, $allowedDoc)) {
            $docName = uniqid() . '_' . basename($docFile['name']);
            $docPath = $uploadDir . $docName;
            
            if (move_uploaded_file($docFile['tmp_name'], $docPath)) {
                // Hapus file lama
                if (file_exists($currentDoc)) {
                    unlink($currentDoc);
                }
                $currentDoc = $docPath;
            } else {
                $_SESSION['alert'] = [
                    'type' => 'danger',
                    'message' => 'Gagal upload dokumen!'
                ];
                header("Location: Kehadiran.php");
                exit();
            }
        } else {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'message' => 'Format dokumen tidak valid! (Hanya PDF/DOC/DOCX)'
            ];
            header("Location: Kehadiran.php");
            exit();
        }
    }

    // Update gambar jika ada file baru
    if ($_FILES['file_name']['name'] != "") {
        $imgFile = $_FILES['file_name'];
        $imgExt = strtolower(pathinfo($imgFile['name'], PATHINFO_EXTENSION));
        $allowedImg = ['jpg', 'jpeg', 'png'];
        
        if (in_array($imgExt, $allowedImg)) {
            $imgName = uniqid() . '_' . basename($imgFile['name']);
            $imgPath = $uploadDir . $imgName;
            
            if (move_uploaded_file($imgFile['tmp_name'], $imgPath)) {
                // Hapus file lama
                if (file_exists($currentImg)) {
                    unlink($currentImg);
                }
                $currentImg = $imgPath;
            } else {
                $_SESSION['alert'] = [
                    'type' => 'danger',
                    'message' => 'Gagal upload gambar!'
                ];
                header("Location: Kehadiran.php");
                exit();
            }
        } else {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'message' => 'Format gambar tidak valid! (Hanya JPG/PNG)'
            ];
            header("Location: Kehadiran.php");
            exit();
        }
    }

    // Update database
    $updateQuery = "UPDATE laporan_kehadiran SET 
                    judul = '$judul',
                    tanggal = '$tanggal',
                    file_path = '$currentDoc',
                    file_name = '$currentImg'
                    WHERE id_kehadiran = '$id_kehadiran'";

    if (mysqli_query($conn, $updateQuery)) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'message' => 'Data berhasil diperbarui!'
        ];
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'Gagal update data: ' . mysqli_error($conn)
        ];
    }

    header("Location: Kehadiran.php");
    exit();
}

if (isset($_POST['hapuskehadiran'])) {
    $id_kehadiran = mysqli_real_escape_string($conn, $_POST['id_kehadiran']);

    // Ambil path file dari database
    $query = "SELECT file_path, file_name FROM laporan_kehadiran WHERE id_kehadiran = '$id_kehadiran'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    // Hapus file dari server
    $fileDeleted = true;
    if (file_exists($data['file_path'])) {
        if (!unlink($data['file_path'])) {
            $fileDeleted = false;
        }
    }
    
    if (file_exists($data['file_name'])) {
        if (!unlink($data['file_name'])) {
            $fileDeleted = false;
        }
    }

    // Hapus dari database
    if ($fileDeleted) {
        $deleteQuery = "DELETE FROM laporan_kehadiran WHERE id_kehadiran = '$id_kehadiran'";
        if (mysqli_query($conn, $deleteQuery)) {
            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => 'Data berhasil dihapus!'
            ];
        } else {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'message' => 'Gagal menghapus data: ' . mysqli_error($conn)
            ];
        }
    } else {
        $_SESSION['alert'] = [
            'type' => 'warning',
            'message' => 'Data database dihapus tapi gagal menghapus beberapa file!'
        ];
    }

    header("Location: Kehadiran.php");
    exit();
}

// Handle Add Rapat
if(isset($_POST['addkegiatan'])){
    $divisi = mysqli_real_escape_string($conn, $_POST['divisi']);
    $jenis_kegiatan = mysqli_real_escape_string($conn, $_POST['jenis_kegiatan']);
    $tanggal_mulai =  mysqli_real_escape_string($conn, $_POST['tanggal_mulai']);
    $tanggal_selesai = mysqli_real_escape_string($conn, $_POST['tanggal_selesai']);
    $status =  mysqli_real_escape_string($conn, $_POST['status']);
    $dokumen_id =  mysqli_real_escape_string($conn, $_POST['dokumen_id']);

    // Tambahkan tanda kutip pada nilai string/date di query
    $query = "INSERT INTO kegiatan (divisi, jenis_kegiatan, tanggal_mulai, tanggal_selesai, status, dokumen_id) 
            VALUES ('$divisi', '$jenis_kegiatan', '$tanggal_mulai', '$tanggal_selesai', '$status', '$dokumen_id')";
    
    $addtotable = mysqli_query($conn, $query);
    
    if ($addtotable) {
        header("Location: Pelatihan_kegiatan_rapat.php");
        exit();
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($conn);
    }
}

// Handle Update Rapat
if(isset($_POST['updatekegiatan'])){
    $idR = mysqli_real_escape_string($conn, $_POST['id_kegiatan']);
    $divisi = mysqli_real_escape_string($conn, $_POST['divisi']);
    $jenis_kegiatan = mysqli_real_escape_string($conn, $_POST['jenis_kegiatan']); // Perbaiki typo di sini
    $tanggal_mulai = mysqli_real_escape_string($conn, $_POST['tanggal_mulai']);
    $tanggal_selesai = mysqli_real_escape_string($conn, $_POST['tanggal_selesai']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $dokumen_id = mysqli_real_escape_string($conn, $_POST['dokumen_id']);

    // Tambahkan tanda kutip pada nilai string/date
    $update = mysqli_query($conn, "UPDATE kegiatan SET 
            divisi = '$divisi',
            jenis_kegiatan = '$jenis_kegiatan',
            tanggal_mulai = '$tanggal_mulai',
            tanggal_selesai = '$tanggal_selesai',
            status = '$status',
            dokumen_id = '$dokumen_id'
            WHERE id_kegiatan = '$idR'"); // Pastikan id_kegiatan adalah kolom yang benar

    if ($update) {
        header('Location: Pelatihan_kegiatan_rapat.php');
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($conn); // Tampilkan error
    }
}


// Handle Delete Rapat
if(isset($_POST['hapuskegiatan'])){
    $idR = $_POST['id_kegiatan'];
    
   // Query untuk hapus data
   $delete = mysqli_query($conn, "DELETE FROM kegiatan WHERE id_kegiatan = '$idR'");
    if ($delete) {
        // Jika berhasil, redirect ke halaman yang sama
        header('Location: Pelatihan_kegiatan_rapat.php');
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Gagal menghapus data";
    }
}


// Handle Delete Rapat
if(isset($_POST['hapuslaporanbulanan'])){
    $idL = $_POST['id_laporan'];
    
   // Query untuk hapus data
   $delete = mysqli_query($conn, "DELETE FROM laporan_bulanan WHERE id_laporan = '$idL'");
    if ($delete) {
        // Jika berhasil, redirect ke halaman yang sama
        header('Location: tahun.php');
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Gagal menghapus data";
    }
}

if(isset($_POST['tambahUser'])) {
    // Tambah User
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);
    
    if($stmt->execute()) {
        $_SESSION['success'] = "User berhasil ditambahkan";
    } else {
        $_SESSION['error'] = "Gagal menambahkan user: " . $stmt->error;
    }
    $stmt->close();
    header("Location: pengaturan_user.php");
    exit();
}

if(isset($_POST['updateUser'])) {
    // Update User
    $id_user = $_POST['id_user'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    
    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, role=? WHERE id_user=?");
    $stmt->bind_param("sssi", $name, $email, $role, $id_user);
    
    if($stmt->execute()) {
        $_SESSION['success'] = "User berhasil diperbarui";
    } else {
        $_SESSION['error'] = "Gagal memperbarui user: " . $stmt->error;
    }
    $stmt->close();
    header("Location: pengaturan_user.php");
    exit();
}

if(isset($_POST['hapusUser'])) {
    // Hapus User
    $id_user = $_POST['id_user'];
    
    $stmt = $conn->prepare("DELETE FROM users WHERE id_user=?");
    $stmt->bind_param("i", $id_user);
    
    if($stmt->execute()) {
        $_SESSION['success'] = "User berhasil dihapus";
    } else {
        $_SESSION['error'] = "Gagal menghapus user: " . $stmt->error;
    }
    $stmt->close();
    header("Location: pengaturan_user.php");
    exit();
}

$currentUserEmail = $_SESSION['email'] ?? '';

$defaultValues = [
    'nama' => '',
    'jabatan' => '',
    'no_hp' => '',
    'alamat' => '',
    'foto' => 'default.jpg',
    'jenis_kelamin' => 'Laki-laki',
    'agama' => 'Islam',
    'angkatan' => ''
];

$user = $defaultValues;

// Ambil data profil
if (!empty($currentUserEmail)) {
    $stmt = $conn->prepare("SELECT * FROM profil WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $currentUserEmail);
        $stmt->execute();
        $result = $stmt->get_result();
        $userFromDb = $result->fetch_assoc();
        if ($userFromDb) {
            $user = $userFromDb;
        }
        $stmt->close();
    } else {
        die("Prepare failed: " . $conn->error);
    }
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $nama = $_POST['nama'] ?? '';
    $jabatan = $_POST['jabatan'] ?? '';
    $no_hp = $_POST['no_hp'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $agama = $_POST['agama'] ?? '';
    $angkatan = $_POST['angkatan'] ?? '';
    $foto = $user['foto'];

    // Upload foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/profil/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileExt = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExt, $allowedTypes)) {
            $newFileName = uniqid() . '.' . $fileExt;
            $targetFile = $targetDir . $newFileName;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
                if ($user['foto'] !== 'default.jpg' && file_exists($targetDir . $user['foto'])) {
                    @unlink($targetDir . $user['foto']);
                }
                $foto = $newFileName;
            }
        }
    }

    // Query insert/update
    $sql = "INSERT INTO profil (email, nama, jabatan, no_hp, alamat, foto, jenis_kelamin, agama, angkatan) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
                nama = VALUES(nama),
                jabatan = VALUES(jabatan),
                no_hp = VALUES(no_hp),
                alamat = VALUES(alamat),
                foto = VALUES(foto),
                jenis_kelamin = VALUES(jenis_kelamin),
                agama = VALUES(agama),
                angkatan = VALUES(angkatan)";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssssssss", 
            $currentUserEmail, $nama, $jabatan, $no_hp, $alamat, $foto, $jenis_kelamin, $agama, $angkatan
        );
        $stmt->execute();
        $stmt->close();

        $_SESSION['success'] = "Profil berhasil diperbarui!";
        header("Location: profile_setting.php");
        exit();
    } else {
        die("Prepare failed during update: " . $conn->error);
    }
}

function timeAgo($datetime) {
    $time = strtotime($datetime);
    $diff = time() - $time;

    $sec = $diff;
    $min = round($diff / 60);
    $hrs = round($diff / 3600);
    $days = round($diff / 86400);
    $weeks = round($diff / 604800);
    $mnths = round($diff / 2600640);
    $yrs = round($diff / 31207680);

    if ($sec <= 60) {
        return "baru saja";
    } elseif ($min <= 60) {
        return $min . " menit lalu";
    } elseif ($hrs <= 24) {
        return $hrs . " jam lalu";
    } elseif ($days <= 7) {
        return $days . " hari lalu";
    } elseif ($weeks <= 4.3) {
        return $weeks . " minggu lalu";
    } elseif ($mnths <= 12) {
        return $mnths . " bulan lalu";
    } else {
        return $yrs . " tahun lalu";
    }
}

// Tambah Libur
if(isset($_POST['addHoliday'])){
    $title = $_POST['title'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'] ?? null;
    $color = $_POST['color'];
    
    // Periksa koneksi database
    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    
    $stmt = $conn->prepare("INSERT INTO academic_holidays (title, start_date, end_date, color) VALUES (?, ?, ?, ?)");
    
    // Tambahkan pengecekan error prepare
    if($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    
    $stmt->bind_param("ssss", $title, $start_date, $end_date, $color);
    $stmt->execute();
    
    header("Location: academic_holidays.php");
    exit;
}

// Edit Libur
if(isset($_POST['updateHoliday'])){
    $id_libur = $_POST['id_libur'];
    $title = $_POST['title'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'] ?? null;
    $color = $_POST['color'];
    
   
   // Tambahkan tanda kutip pada nilai string/date
    $update = mysqli_query($conn, "UPDATE academic_holidays SET 
            id_libur = '$id_libur',
            title = '$title',
            start_date = '$start_date',
            end_date = '$end_date',
            color = '$color'
            WHERE id_libur = '$id_libur'"); // Pastikan id_kegiatan adalah kolom yang benar

 if ($update) {
        header('Location: academic_holidays.php');
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($conn); // Tampilkan error
    }
}

?>


