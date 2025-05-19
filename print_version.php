<?php 
require 'function.php';
require 'cek.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <title>Cetak Laporan - Administrasi Divisi</title>
        <style>
        body {
            font-family: Arial, sans-serif;
            color: black;
            background-color: white; /* Background putih */
            margin: 20px;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 100px;
            margin-right: 15px;
        }
        .header .text {
            text-align: left;
        }
        .header .text h3, 
        .header .text h5 {
            margin: 5px 0;
        }
        .alamat {
            text-align: center;
            font-size: 14px;
            margin-top: 5px;
        }
        h4 {
            text-align: center;
            margin-top: 20px;
        }
        table {
            width: 80%;
            max-width: 800px;
            border-collapse: collapse;
            margin: 0 auto;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="card bg-white text-black mb-4">
        <div class="card-body text-center">
            <div class="table-responsive">
                <div class="header">
                    <img src="https://3.bp.blogspot.com/-MYWK0OeoYfU/XJsBH5dmJ6I/AAAAAAAALYo/lLHintm61FANouhpNd6uzuqPs3PgapS2wCLcBGAs/s1600/logo-bawaslu%2BPersegi.png" width="200" alt="logo Bawaslu Provinsi Sulawesi Selatan">
                        <div class="text">
                             <h5>BAWASLU PROVINSI SULAWEI SELATAN </h5>
                            <h6>BADAN PENGAWASAN PEMILIHAN UMUM</h6>
                        </div>
                    </div>
                <div class="info">
                    <p>Alamat : Jl. A. P. Pettarani No.98, Bua Kana, Kec. Rappocini, Kota Makassar, Sulawesi Selatan 90222</p>
                </div>
                    <h3 class="text-center">RIWAYAT AKTIVITAS KEGIATAN DIVISI BAWASLU</h3>
                </div>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th>Divisi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Laporan Kegiatan</td>
                            <td>Januari</td>
                            <td>2024</td>
                            <td>Divisi Penanganan Pelanggaran</td>
                            <td>Disetujui</td>
                            <td>****</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Laporan Keuangan</td>
                            <td>Februari</td>
                            <td>2024</td>
                            <td>Divisi Humas</td>
                            <td>Pending</td>
                            <td>****</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Laporan Pelatihan</td>
                            <td>Maret</td>
                            <td>2024</td>
                            <td>Divisi Pencegahan Dan Parmas</td>
                            <td>Ditolak</td>
                            <td>****</td>
                        </tr>
                    </tbody>                           
                </table>
                 <!-- Tambahkan Waktu Cetak -->
                        <p class="text-center">Dicetak pada: 2/25/2025</p>

                <!-- Tombol Cetak di Tengah -->
                        <div class="text-center">
                        <button onclick="window.print()" class="btn btn-primary no-print">
                            <i class="fas fa-print"></i> Cetak Laporan
                        </button>
                    </div>
                </div>
            </div>
        </table>
    </body>
</html>
