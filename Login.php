<?php
require 'function.php'; // Include file function.php

// Panggil fungsi check session
checkSessionAndRedirect();

// Proses login jika ada data yang dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $error = processLogin($conn);
    if ($error) {
        header("Location: login.php?" . $error);
        exit();
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
        <link rel="icon" type="image/jpeg" href="image/logo-bawaslu-provinsi.jpeg">
        <title>ADMINISTRASI DIVISI - Dashboard Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <style>
            body {
                background: url('https://cdn.rri.co.id/berita/1/images/1676962469741-image-bawaslu/1676962469741-image-bawaslu.webp') no-repeat center center fixed;
                background-size: cover;
                position: relative;
            }
            
            body::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5); /* Overlay gelap untuk meningkatkan keterbacaan */
                z-index: -1;
            }
            
            .card {
                background-color: rgba(255, 255, 255, 0.9); /* Kartu login sedikit transparan */
                border-radius: 10px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            }
            
            .text-center img {
                filter: drop-shadow(0 0 5px rgba(0, 0, 0, 0.3));
            }
        </style>
    </head>
    <body>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="text-center mt-4">
                                        <img src="https://3.bp.blogspot.com/-MYWK0OeoYfU/XJsBH5dmJ6I/AAAAAAAALYo/lLHintm61FANouhpNd6uzuqPs3PgapS2wCLcBGAs/s1600/logo-bawaslu%2BPersegi.png" width="200" alt="logo Bawaslu Provinsi Sulawesi Selatan">
                                    </div>
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">Login</h3>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" action="">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input class="form-control py-4" name="email" id="inputEmailAddress" type="email" placeholder="Enter email address" required />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input class="form-control py-4" name="password" id="inputPassword" type="password" placeholder="Enter password" required />
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary" name="login" type="submit">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    <?php
                                    if (isset($_GET['error'])) {
                                        echo '<p style="color:red; text-align:center;">Email atau password salah!</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>