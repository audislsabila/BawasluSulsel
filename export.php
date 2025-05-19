<?php 
require 'function.php';
require 'cek.php';
?>
<html>
<head>
  <title>Laporan Bulanan</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <style>
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
        </style>
</head>

<body>
<div class="container">
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
        <table class="table table-bordered" id="mauexport" width="100%" cellspacing="0">
            <thead>
                <tr class="text-white">
                    <th>#</th>
                    <th>Judul</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Divisi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $ambilsemuadatabulanan = mysqli_query($conn, "SELECT * FROM laporan_bulanan");
                while ($fetcharray = mysqli_fetch_array($ambilsemuadatabulanan)) {
                    $judul = $fetcharray['judul'];
                    $bulan = $fetcharray['bulan'];
                    $tahun = $fetcharray['tahun'];
                    $divisi = $fetcharray['divisi'];
                    $status = $fetcharray['status'];
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $judul; ?></td>
                    <td><?php echo $bulan; ?></td>
                    <td><?php echo $tahun; ?></td>
                    <td><?php echo $divisi; ?></td>
                    <td><?php echo $status; ?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    $('#mauexport').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>

</body>
</html>