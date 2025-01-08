<?php
require 'function.php';
require 'cek.php';

// Tangkap query pencarian dari URL (jika ada)
$search = isset($_GET['search']) ? $_GET['search'] : '';
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stock Barang</title>
  <link rel="icon" href="assets/img/icon.png" type="image/x-icon">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

  <style>
    /* Mengurangi margin dan padding */
    body {
      margin: 10;
      padding: 10;
    }

    /* Menambahkan sedikit style untuk mempercantik tabel */
    .dataTables_filter {
      display: none !important; /* Menyembunyikan fitur pencarian */
    }

    h1 {
      display: none !important;
    }

    /* Menambahkan styling pada header tabel */
    .table thead th {
      background-color: #007bff;
      color: white;
      text-align: center;
      border-bottom: 2px solid #0056b3; /* Garis bawah yang lebih tebal pada header */
    }

    /* Menambahkan styling untuk border tabel yang lebih rapi */
    .table-bordered {
      border: 1px solid #dee2e6 !important;
      border-collapse: separate; /* Memisahkan border untuk setiap sel */
      border-spacing: 0; /* Menghilangkan jarak antar sel */
    }

    /* Menambahkan border pada setiap cell tabel */
    .table-bordered th, .table-bordered td {
      border: 1px solid #dee2e6;
      padding: 5px; /* Menurunkan padding untuk mengurangi ruang kosong */
    }

    /* Styling untuk tabel agar lebih responsif */
    .table-responsive {
      margin-top: 20px;
    }

    /* Styling untuk header halaman */
    h4.text-center {
      margin-bottom: 30px;
      color: #343a40;
      font-weight: bold;
    }

    /* CSS untuk memastikan header tetap tampil saat print */
    @media print {
      body {
        -webkit-print-color-adjust: exact;
      }

      .kop-surat {
        page-break-before: always;
      }

      /* Memastikan header tabel tetap di atas dan tidak terganggu oleh scrolling */
      .dataTables_wrapper .dataTables_scrollHead {
        position: relative;
        width: 100%;
        z-index: 100;
      }

      /* Mengatur agar body tabel tidak tertutup oleh header */
      .dataTables_scrollBody {
        margin-top: 80px;
      }

      /* Memastikan header tetap di bagian atas halaman saat print */
      thead {
        display: table-header-group !important;
      }

      /* Menyembunyikan elemen lain yang tidak diinginkan saat print */
      .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate {
        display: none;
      }

      /* Untuk membuat header tabel tetap di halaman pertama */
      .table thead th {
        background-color: #007bff !important;
        color: white !important;
        text-align: center !important;
        font-weight: bold !important;
      }

      /* Menambahkan border pada tabel saat print */
      .table-bordered th, .table-bordered td {
        border: 1px solid #000 !important;
      }

      /* Menambahkan border untuk setiap kolom pada print */
      .table-bordered th, .table-bordered td {
        border: 1px solid #000 !important;
      }

    }
  </style>

</head>

<body>
<div class="container">
    <div class="table-responsive">
      <!-- Tombol Back dengan Icon -->
    <button type="button" class="btn btn-secondary mb-3" onclick="goBack()" >Back</button>
        <table class="table table-bordered" id="mauexport" width="99.8%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Deskripsi</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Modifikasi query SQL untuk menyaring data berdasarkan pencarian
                $query = "SELECT * FROM stock";
                if ($search) {
                    $query .= " WHERE namabarang LIKE '%$search%' OR deskripsi LIKE '%$search%'";
                }

                // Eksekusi query
                $ambilsemuadatastock = mysqli_query($conn, $query);
                $i = 1;
                while($data = mysqli_fetch_array($ambilsemuadatastock)){
                    $namabarang = $data['namabarang'];
                    $deskripsi = $data['deskripsi'];
                    $stock = $data['stock'];
                    $idb = $data['idbarang'];
                ?>
                <tr>
                    <td><?=$i++;?></td>
                    <td><?php echo $namabarang;?></td>
                    <td><?php echo $deskripsi;?></td>
                    <td><?php echo $stock?></td>
                </tr>
                <?php
                };
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>  
function goBack() {
    window.location.href = 'index.php';
    window.close(); // Menutup halaman ini setelah mengarahkan ke index.php
}
</script>

<script>  
$(document).ready(function() {
    var table = $('#mauexport').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                text: 'Print <img src="assets/img/print.png" alt="Print" width="35" height="35">',
                customize: function (win) {
                    var logo = '<img src="assets/img/logo.png" width="130" height="100">';
                    var kopSurat = ` 
                        <div class="kop-surat" style="text-align: center; margin-bottom: 10px; padding: 20px 0;">
                            <table width="100%" style="border-collapse: collapse; table-layout: fixed;">
                                <tr>
                                    <!-- Logo Kiri -->
                                    <td width="30%" style="vertical-align: top; text-align: center; margin-left: 50px">
                                        ${logo}
                                    </td>
                                    <!-- Informasi Perusahaan Kanan -->
                                    <td width="70%" style="vertical-align: top; text-align: center; padding-right: 270px">
                                        <h3 style="margin: 0; font-size: 24px; font-weight: bold;">PT. MENCARI CINTA SEJATI</h3>
                                        <p style="margin: 5px 0; font-size: 14px;">Jl. Angker No. 008 (Saraz), Jakarta Pusat, Jakarta, DKI Jakarta, 10210</p>
                                        <p style="margin: 5px 0; font-size: 14px;">(021) 12345678</p>
                                        <p style="margin: 5px 0; font-size: 14px;"><a href="mailto:info@xyzindonesia.com" style="text-decoration: none; color: black;">info@xyzindonesia.com</a></p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    `;
                    
                    // Menambahkan kop surat ke dalam body halaman print
                    $(win.document.body).prepend(kopSurat);

                    // Menambahkan CSS untuk hanya menampilkan kop surat di halaman pertama
                    $(win.document.body).find('style').remove(); // Menghapus style lama jika ada
                    $(win.document.body).prepend(`
                        <style>
                            @media print {
                                body {
                                    -webkit-print-color-adjust: exact;
                                }
                                .kop-surat {
                                    page-break-before: always;
                                }
                                .kop-surat + * {
                                    page-break-before: always;
                                }
                            }
                        </style>
                    `);
                }
            }
        ]
    });
});
</script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

</body>
</html>
