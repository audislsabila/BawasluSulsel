<?php 
require 'function.php';
require 'cek.php';

$role = checkRole();
if ($role != 'admin') {
    header("location: profile_setting.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("location: profile_setting.php");
    exit();
}

$id = $_GET['id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $id"));

if (!$user) {
    header("location: profile_setting.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    
    $query = "UPDATE users SET 
              nama = '$nama', 
              jabatan = '$jabatan', 
              no_hp = '$no_hp', 
              alamat = '$alamat', 
              email = '$email',
              role = '$role'
              WHERE id = $id";
    
    if (mysqli_query($conn, $query)) {
        $success = "Profil pengguna berhasil diperbarui!";
        $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $id"));
    } else {
        $error = "Gagal memperbarui profil: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Edit Pengguna</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <?php include 'navbar.php'; ?>
    
    <div id="layoutSidenav">
        <?php include 'sidebar.php'; ?>
        
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Edit Pengguna</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="Dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="profile_setting.php">Pengaturan Profil</a></li>
                        <li class="breadcrumb-item active">Edit Pengguna</li>
                    </ol>
                    
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php endif; ?>
                    
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-user-edit mr-1"></i>
                            Edit Data Pengguna
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="nama">Nama Lengkap</label>
                                            <input class="form-control" id="nama" name="nama" type="text" value="<?= htmlspecialchars($user['nama']) ?>" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="jabatan">Jabatan</label>
                                            <input class="form-control" id="jabatan" name="jabatan" type="text" value="<?= htmlspecialchars($user['jabatan']) ?>" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="no_hp">Nomor HP</label>
                                            <input class="form-control" id="no_hp" name="no_hp" type="text" value="<?= htmlspecialchars($user['no_hp']) ?>" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="email">Email</label>
                                            <input class="form-control" id="email" name="email" type="email" value="<?= htmlspecialchars($user['email']) ?>" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="small mb-1" for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= htmlspecialchars($user['alamat']) ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="small mb-1" for="role">Role</label>
                                    <select class="form-control" id="role" name="role" required>
                                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                                    </select>
                                </div>
                                <div class="form-group mt-4 mb-0">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    <a href="profile_setting.php" class="btn btn-secondary">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
            <?php include 'footer.php'; ?>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>