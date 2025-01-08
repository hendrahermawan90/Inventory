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
        <title>Stock Peminjaman Barang</title>
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
                        <h1 class="mt-4">Peminjaman Barang</h1>
                        <div class="card mb-4">
                        <div class="card-header">
                                    <!-- Button to Open the Modal dan Filter Form Sejajar -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <!-- Button to Open the Modal -->
                                        <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#myModal">
                                            <i class="fas fa-plus"></i> Tambah Barang Dipinjam
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
                                                <th>Peminjam</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php
                                             if(isset($_POST['filter_tgl'])){
                                                $mulai = $_POST['tgl_mulai'];
                                                $selesai = $_POST['tgl_selesai'];
                                                
                                                if($mulai!=null || $selesai!=null){
                                                    $ambilsemuadatastock = mysqli_query($conn, "select * from peminjaman p, stock s where s.idbarang = p.idbarang and tanggal BETWEEN'$mulai' and DATE_ADD('$selesai',INTERVAL 1 DAY)");
                                                } else {
                                                    $ambilsemuadatastock = mysqli_query($conn, "select * from peminjaman p, stock s where s.idbarang = p.idbarang");
                                                }
                                                
                                            } else {
                                                $ambilsemuadatastock = mysqli_query($conn, "select * from peminjaman p, stock s where s.idbarang = p.idbarang");
                                            }
                                            while($data=mysqli_fetch_array($ambilsemuadatastock)){
                                                $idk = $data['idpeminjaman'];
                                                $idb = $data['idbarang'];
                                                $tanggal = $data['tanggalpinjam'];
                                                $namabarang = $data['namabarang'];
                                                $qty = $data['qty'];
                                                $penerima = $data['peminjam'];
                                                $status = $data['status'];
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
                                                <td><?=$status;?></td>
                                                <td>
                                                    <?php
                                                    //cek status
                                                    if($status=='Dipinjam'){
                                                        echo '<div style="display: flex; justify-content: center; align-items: center; margin-top: 30px;">
                                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#edit' . $idk . '">
                                                        Selesai
                                                        </button>
                                                        </div>';

                                                    } else {
                                                        //jika statusnya bukan dipinjam(sudah kembali)
                                                        echo '<div style="display: flex; justify-content: center; align-items: center; height: 100px;">
                                                        <i class="fa fa-check fa-lg"></i>
                                                      </div>';
                                                
                                                    }
                                                    
                                                ?>
                                                </td>
                                            </tr>
                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?=$idk;?>">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                        <h4 class="modal-title">Selesaikan</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        
                                                        <!-- Modal body -->
                                                        <form method="post">
                                                        <div class="modal-body">
                                                            Apakah barang ini sudah selesai dipinjam?
                                                        <br>
                                                        <br>
                                                        <input type="hidden" name="idpinjam" value="<?=$idk;?>">
                                                        <input type="hidden" name="idbarang" value="<?=$idb;?>">
                                                        <button type="submit" class="btn btn-primary" name="barangkembali">Sudah</button>
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
     <div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Data Peminjaman</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Modal body -->
      <form method="post">
      <div class="modal-body">

      <!-- Input untuk filter barang -->
      <input type="text" id="search-barang-peminjaman" class="form-control" list="barang-list-peminjaman" placeholder="Cari Barang...">
      <datalist id="barang-list-peminjaman">
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
      <select name="barangnya" id="barang-select-peminjaman" class="form-control" style="display: none;">
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
      <input type="text" name="penerima" class="form-control" placeholder="Peminjam" required>
      <br>
      <button type="submit" class="btn btn-primary" name="pinjam">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- JavaScript untuk menghubungkan input dan select -->
<script>
  document.getElementById('search-barang-peminjaman').addEventListener('input', function () {
    let searchValue = this.value.toLowerCase();
    let options = document.querySelectorAll('#barang-list-peminjaman option');
    let select = document.getElementById('barang-select-peminjaman');

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
