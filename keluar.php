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
        <title>Barang Keluar</title>
        <link rel="icon" href="assets/img/icon.png" type="image/x-icon">
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <style>
            .zoomable{
                width: 100px;
            }
            .zoomable:hover{
                transform: scale(2.5);
                transition: 0.3s ease;
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.html">Kelompok 1</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                        <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-warehouse"></i></div>
                                Stock Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard-check"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-dolly-flatbed"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link" href="peminjaman.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-suitcase"></i></div>
                                Peminjaman Barang
                            </a>
                            <a class="nav-link" href="admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-alt"></i></div>
                                Kelola Admin
                            </a>
                            <a class="nav-link" href="logout.php"> <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Barang Keluar</h1>
                        <div class="card mb-4">
                        <div class="card-header">
                                    <!-- Button to Open the Modal dan Filter Form Sejajar -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <!-- Button to Open the Modal -->
                                        <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#myModal">
                                            <i class="fas fa-plus"></i> Tambah Barang Keluar
                                        </button>

                                        <!-- Form Filter Tanggal -->
                                        <form method="post" class="form-inline d-flex justify-content-between align-items-center">
                                            <div class="form-group">
                                                <label for="tgl_mulai" class="mr-2">Dari Tanggal:</label>
                                                <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control rounded-pill shadow-sm" required>
                                            </div>
                                            <div class="form-group ml-3">
                                                <label for="tgl_selesai" class="mr-2">Sampai:</label>
                                                <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control rounded-pill shadow-sm" required>
                                            </div>
                                            <button type="submit" name="filter_tgl" class="btn btn-info ml-3 px-4 py-2 rounded-pill shadow-sm">
                                                <i class="fas fa-filter"></i> Filter
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Gambar</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Penerima</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php
                                             if(isset($_POST['filter_tgl'])){
                                                $mulai = $_POST['tgl_mulai'];
                                                $selesai = $_POST['tgl_selesai'];
                                                
                                                if($mulai!=null || $selesai!=null){
                                                    $ambilsemuadatastock = mysqli_query($conn, "select * from keluar k, stock s where s.idbarang = k.idbarang and tanggal BETWEEN'$mulai' and DATE_ADD('$selesai',INTERVAL 1 DAY)");
                                                } else {
                                                    $ambilsemuadatastock = mysqli_query($conn, "select * from keluar k, stock s where s.idbarang = k.idbarang");
                                                }
                                                
                                            } else {
                                                $ambilsemuadatastock = mysqli_query($conn, "select * from keluar k, stock s where s.idbarang = k.idbarang");
                                            }
                                            while($data=mysqli_fetch_array($ambilsemuadatastock)){
                                                $idk = $data['idkeluar'];
                                                $idb = $data['idbarang'];
                                                $tanggal = $data['tanggal'];
                                                $namabarang = $data['namabarang'];
                                                $qty = $data['qty'];
                                                $penerima = $data['penerima'];
                                                 //ada gambar atau tidak
                                                 $gambar = $data['image']; //ambil gambar
                                                 if($gambar==null){
                                                     //jika tidak ada gambar
                                                     $img = 'No Photo';
                                                 } else {
                                                     //jika ada gambar
                                                     $img = '<img src="images/'.$gambar.'" class="zoomable">';
                                                 }
                                            
                                            ?>
                                            <tr>
                                                <td><?= date('d-m-Y H:i:s', strtotime($tanggal)); ?></td>
                                                <td><?=$img;?></td>
                                                <td><?=$namabarang;?></td>
                                                <td><?=$qty;?></td>
                                                <td><?=$penerima;?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idk;?>">
                                                    Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idk;?>">
                                                    Delete
                                                    </button>
                                                </td>
                                            </tr>
                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?=$idk;?>">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                        <h4 class="modal-title">Edit barang</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        
                                                        <!-- Modal body -->
                                                        <form method="post">
                                                        <div class="modal-body">
                                                        <input type="text" name="penerima" value="<?=$penerima;?>" class="form-control" required>
                                                        <br>
                                                        <input type="number" name="qty" value="<?=$qty;?>" class="form-control" required>
                                                        <br>
                                                        <input type="hidden" name="idb" value="<?=$idb;?>">
                                                        <input type="hidden" name="idk" value="<?=$idk;?>">
                                                        <button type="submit" class="btn btn-primary" name="updatebarangkeluar">Submit</button>
                                                        </div>
                                                        </form>

                                                </div>
                                                </div>
                                            </div>

                                            <!-- Delete Modal -->
                                                <div class="modal fade" id="delete<?=$idk;?>">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                        <h4 class="modal-title">Hapus barang?</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        
                                                        <!-- Modal body -->
                                                        <form method="post">
                                                        <div class="modal-body">
                                                        Apakah anda yakin ingin menghapus <?=$namabarang;?>?
                                                        <input type="hidden" name="idb" value="<?=$idb;?>">
                                                        <input type="hidden" name="kty" value="<?=$qty;?>">
                                                        <input type="hidden" name="idk" value="<?=$idk;?>">
                                                        <br>
                                                        <br>
                                                        <button type="submit" class="btn btn-danger" name="hapusbarangkeluar">Hapus</button>
                                                        </div>
                                                        </form>

                                                    </div>
                                                    </div>
                                                </div>

                                            <?php
                                            };
                                            
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
     <!-- The Modal -->
   <!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Barang Keluar</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Modal body -->
      <form method="post">
      <div class="modal-body">

      <!-- Input untuk filter barang -->
      <input type="text" id="search-barang-keluar" class="form-control" list="barang-list-keluar" placeholder="Cari Barang...">
      <datalist id="barang-list-keluar">
          <?php
              $ambilsemuadatanya = mysqli_query($conn,"select * from stock");
              while($fetcharray = mysqli_fetch_array($ambilsemuadatanya)){
                  $namabarangnya = $fetcharray['namabarang'];
                  $idbarangnya = $fetcharray['idbarang'];
          ?>   
          <option value="<?=$namabarangnya;?>" data-id="<?=$idbarangnya;?>">
          <?php
              }
          ?>
      </datalist>
      <br>

      <!-- Hidden select option yang akan digunakan untuk pengiriman data -->
      <select name="barangnya" id="barang-select-keluar" class="form-control" style="display: none;">
          <?php
              $ambilsemuadatanya = mysqli_query($conn,"select * from stock");
              while($fetcharray = mysqli_fetch_array($ambilsemuadatanya)){
                  $namabarangnya = $fetcharray['namabarang'];
                  $idbarangnya = $fetcharray['idbarang'];
          ?>   
          <option value="<?=$idbarangnya;?>"><?=$namabarangnya;?></option>
          <?php
              }
          ?>
      </select>
      <br>

      <input type="number" name="qty" class="form-control" placeholder="Quantity" required>
      <br>
      <input type="text" name="penerima" class="form-control" placeholder="Penerima" required>
      <br>
      <button type="submit" class="btn btn-primary" name="addbarangkeluar">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- JavaScript untuk menghubungkan input dan select -->
<script>
  document.getElementById('search-barang-keluar').addEventListener('input', function () {
    let searchValue = this.value.toLowerCase();
    let options = document.querySelectorAll('#barang-list-keluar option');
    let select = document.getElementById('barang-select-keluar');

    // Menyaring barang berdasarkan input
    options.forEach(option => {
      if (option.value.toLowerCase().includes(searchValue)) {
        option.style.display = '';
      } else {
        option.style.display = 'none';
      }
    });

    // Jika ada pilihan yang cocok, pilih ID yang sesuai
    let matchingOption = Array.from(options).find(option => option.value.toLowerCase() === searchValue.toLowerCase());
    if (matchingOption) {
      select.value = matchingOption.getAttribute('data-id');
    }
  });
</script>
</html>
