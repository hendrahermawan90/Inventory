  <?php
  session_start();

//Membuat koneksi ke database
  $conn = mysqli_connect("localhost","root","","stockbarang");
  
// Menambah barang baru
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    // Validasi jika ada form yang kosong
    if (empty($namabarang) || empty($deskripsi) || empty($stock)) {
        // Menampilkan popup jika ada form yang kosong
        echo '
        <script>
            alert("Form tidak boleh kosong !");
            window.location.href="index.php";
        </script>
        ';
        exit(); // Menghentikan eksekusi lebih lanjut jika ada form yang kosong
    }

    // Soal gambar
    $allowed_extension = array('png','jpg');
    $nama = $_FILES['file']['name']; // Mengambil nama file gambar
    $dot = explode('.',$nama);
    $ekstensi = strtolower(end($dot));
    $ukuran = $_FILES['file']['size']; // Mengambil ukuran file
    $file_tmp = $_FILES['file']['tmp_name']; // Mengambil lokasi file

    // Jika gambar tidak ada yang di-upload
    if ($_FILES['file']['error'] == 4) {
        // Menampilkan popup jika gambar tidak ada
        echo '
        <script>
            alert("Harus menyertakan Foto barang");
            window.location.href="index.php";
        </script>
        ';
        exit(); // Menghentikan eksekusi lebih lanjut jika gambar tidak ada
    }

    // Penamaan file -> enkripsi
    $image = md5(uniqid($nama,true) . time()).'.'.$ekstensi; // Menggabungkan nama file yang dienkripsi dengan ekstensi
    
    // Validasi apakah barang sudah ada atau belum
    $cek = mysqli_query($conn, "SELECT * FROM stock WHERE namabarang='$namabarang'");
    $hitung = mysqli_num_rows($cek);

    if ($hitung < 1) {
        // Jika barang belum ada

        // Proses upload gambar
        if (in_array($ekstensi, $allowed_extension) === true) {
            // Validasi ukuran file
            if ($ukuran < 15000000) {
                move_uploaded_file($file_tmp, 'images/'.$image);

                $addtotable = mysqli_query($conn, "INSERT INTO stock (namabarang, deskripsi, stock, image) VALUES('$namabarang', '$deskripsi', '$stock','$image')");
                if ($addtotable) {
                    echo '
                <script>
                    alert("Berhasil Menambahkan Data !");
                    window.location.href="index.php";
                </script>
                ';
                } else {
                    echo '
                <script>
                    alert("Gagal Menambahkan Data !");
                    window.location.href="index.php";
                </script>
                ';
                }
            } else {
                // Jika ukuran file lebih dari 15MB
                echo '
                <script>
                    alert("Ukuran terlalu besar");
                    window.location.href="index.php";
                </script>
                ';
            }
        } else {
            // Jika file tidak dalam format png/jpg
            echo '
            <script>
                alert("File harus png/jpg");
                window.location.href="index.php";
            </script>
            ';
        }
    } else {
        // Jika barang sudah ada
        echo '
        <script>
            alert("Nama barang sudah terdaftar");
            window.location.href="index.php";
        </script>
        ';
    }
};


//menambah barang masuk
  if(isset($_POST['barangmasuk'])){
      $barangnya = $_POST['barangnya'];
      $penerima = $_POST['penerima'];
      $qty = $_POST['qty'];

      $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
      $ambildatanya = mysqli_fetch_array($cekstocksekarang);

      $stocksekarang = $ambildatanya['stock'];
      $tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;

      $addtomasuk = mysqli_query($conn, "insert into masuk (idbarang, keterangan, qty) values('$barangnya', '$penerima','$qty')");
      $updatestockmasuk = mysqli_query($conn, "update stock set stock='$tambahkanstocksekarangdenganquantity'where idbarang='$barangnya'");
      if($addtomasuk&&$updatestockmasuk){
        echo '
        <script>
            alert("Berhasil Menambahkan Data !");
            window.location.href="masuk.php";
        </script>
        ';
      } else {
        echo '
        <script>
            alert("Gagal Menambahkan Data !");
            window.location.href="masuk.php";
        </script>
        ';
      }
  }

//menambah barang keluar
  if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];

    if($stocksekarang >= $qty){
        //kalau barangnya cukup
        $tambahkanstocksekarangdenganquantity = $stocksekarang-$qty;

        $addtokeluar = mysqli_query($conn, "insert into keluar (idbarang, penerima, qty) values('$barangnya', '$penerima','$qty')");
        $updatestockmasuk = mysqli_query($conn, "update stock set stock='$tambahkanstocksekarangdenganquantity'where idbarang='$barangnya'");
        if($addtokeluar&&$updatestockmasuk){
            echo '
            <script>
                alert("Berhasil Menambahkan Data !");
                window.location.href="keluar.php";
            </script>
            ';
        } else {
            echo '
            <script>
                alert("Gagal Menambahkan Data !");
                window.location.href="keluar.php";
            </script>
            ';
        }
    } else {
        //kalau barangnya ga cukup
        echo '
        <script>
            alert("Stock saat ini tidak mencukupi !");
            window.location.href="keluar.php";
        </script>
        ';
    }
  }

//update info barang
  if(isset($_POST['updatebarang'])){
      $idb = $_POST['idb'];
      $namabarang = $_POST['namabarang'];
      $deskripsi = $_POST['deskripsi'];
      //soal gambar
      $allowed_extension = array('png','jpg');
      $nama = $_FILES['file']['name']; //ngambil nama file gambar
      $dot = explode('.',$nama);
      $ekstensi = strtolower(end($dot));
      $ukuran = $_FILES['file']['size']; //ngambil sieze filenya
      $file_tmp = $_FILES['file']['tmp_name']; //ngambil lokasi filenya

      //penamaan file -> enkripsi
      $image = md5(uniqid($nama,true) . time()).'.'.$ekstensi; //meggabungkan nama file yg dienkripsi dgn ekstensinya

     if($ukuran==0){
        //jika tidak ingin upload
        $update = mysqli_query($conn, "update stock set namabarang='$namabarang', deskripsi='$deskripsi' where idbarang = '$idb'");
        if($update){
            echo '
            <script>
                alert("Berhasil Mengedit Data !");
                window.location.href="index.php";
            </script>
            ';
        } else {
            echo '
            <script>
                alert("Gagal Mengedit Data !");
                window.location.href="index.php";
            </script>
            ';
        }
     } else {
        //jika ingin
        move_uploaded_file($file_tmp, 'images/'.$image);
        $update = mysqli_query($conn, "update stock set namabarang='$namabarang', deskripsi='$deskripsi', image='$image' where idbarang = '$idb'");
        if($update){
            echo '
            <script>
                alert("Berhasil Mengedit Data !");
                window.location.href="index.php";
            </script>
            ';
        } else {
            echo '
            <script>
                alert("Gagal Mengedit Data !");
                window.location.href="index.php";
            </script>
            ';
        }
     }
  }

//menghapus barang dari stock
  if (isset($_POST['hapusbarang'])) {
      $idb = $_POST['idb']; // id barang yang akan dihapus
  
      // Cek apakah barang ada di tabel 'masuk', 'keluar', atau 'peminjaman'
      $cekMasuk = mysqli_query($conn, "SELECT * FROM masuk WHERE idbarang='$idb'");
      $cekKeluar = mysqli_query($conn, "SELECT * FROM keluar WHERE idbarang='$idb'");
      $cekPeminjaman = mysqli_query($conn, "SELECT * FROM peminjaman WHERE idbarang='$idb'");
  
      // Jika ada data terkait, hapus terlebih dahulu data tersebut
      if (mysqli_num_rows($cekMasuk) > 0) {
          mysqli_query($conn, "DELETE FROM masuk WHERE idbarang='$idb'");
      }
      if (mysqli_num_rows($cekKeluar) > 0) {
          mysqli_query($conn, "DELETE FROM keluar WHERE idbarang='$idb'");
      }
      if (mysqli_num_rows($cekPeminjaman) > 0) {
          mysqli_query($conn, "DELETE FROM peminjaman WHERE idbarang='$idb'");
      }
  
      // Menghapus gambar barang
      $gambar = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
      $get = mysqli_fetch_array($gambar);
      $img = 'images/' . $get['image']; // Path gambar
      if (file_exists($img)) {
          unlink($img); // Menghapus gambar
      }
  
      // Menghapus barang dari tabel stock
      $hapus = mysqli_query($conn, "DELETE FROM stock WHERE idbarang='$idb'");
  
      if ($hapus) {
        // Jika penghapusan sukses, tampilkan notifikasi dan redirect
        echo '
            <script>
                alert("Barang berhasil dihapus!");
                window.location.href="index.php"; // Ganti dengan halaman tujuan
            </script>
        ';
    } else {
        // Jika penghapusan gagal, tampilkan notifikasi dan redirect
        echo '
            <script>
                alert("Gagal menghapus barang!");
                window.location.href="index.php"; // Ganti dengan halaman tujuan
            </script>
        ';
    }
  }

  

  
//mengubah data barang masuk
  if(isset($_POST['updatebarangmasuk'])){
      $idb = $_POST['idb'];
      $idm = $_POST['idm'];
      $deskripsi = $_POST['keterangan'];
      $qty = $_POST['qty'];

      $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
      $stocknya = mysqli_fetch_array($lihatstock);
      $stockskrg = $stocknya['stock'];

      $qtyskrg = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
      $qtynya = mysqli_fetch_array($qtyskrg);
      $qtyskrg = $qtynya['qty'];

      if($qty>$qtyskrg){
          $selisih = $qty-$qtyskrg;
          $kurangin = $stockskrg - $selisih;
          $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
          $updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
              if($kurangistocknya&&$updatenya){
                  header('location:masuk.php');
                } else {
                    echo 'Gagal';
                    header('location:masuk.php');
              }
      } else {
          $selisih = $qtyskrg-$qty;
          $kurangin = $stockskrg + $selisih;
          $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
          $updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
              if($kurangistocknya&&$updatenya){
                echo '
                <script>
                    alert("Berhasil Mengedit Data !");
                    window.location.href="masuk.php";
                </script>
                ';
                } else {
                    echo '
                    <script>
                        alert("Gagal Mengedit Data !");
                        window.location.href="masuk.php";
                    </script>
                    ';
              }
      }
  }

//menghapus barang masuk
  if(isset($_POST['hapusbarangmasuk'])){
      $idb = $_POST['idb'];
      $qty = $_POST['kty'];
      $idm = $_POST['idm'];

      $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
      $data = mysqli_fetch_array($getdatastock);
      $stok = $data['stock'];

      $selisih = $stok-$qty;

      $update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idb'");
      $hapusdata = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");

      if($update&&$hapusdata){
        echo '
        <script>
            alert("Berhasil Menghapus Data !");
            window.location.href="masuk.php";
        </script>
        ';
      } else {
        echo '
        <script>
            alert("Gagal Menghapus Data !");
            window.location.href="masuk.php";
        </script>
        ';
      }

  }



//mengubah data barang keluar
  if(isset($_POST['updatebarangkeluar'])){
      $idb = $_POST['idb'];
      $idk = $_POST['idk'];
      $penerima = $_POST['penerima'];
      $qty = $_POST['qty'];

      $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
      $stocknya = mysqli_fetch_array($lihatstock);
      $stockskrg = $stocknya['stock'];

      $qtyskrg = mysqli_query($conn, "select * from keluar where idkeluar='$idk'");
      $qtynya = mysqli_fetch_array($qtyskrg);
      $qtyskrg = $qtynya['qty'];

      if($qty>$qtyskrg){
          $selisih = $qty-$qtyskrg;
          $kurangin = $stockskrg - $selisih;
          $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
          $updatenya = mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima' where idkeluar='$idk'");
              if($kurangistocknya&&$updatenya){
                  header('location:keluar.php');
                } else {
                    echo 'Gagal';
                    header('location:keluar.php');
              }
      } else {
          $selisih = $qtyskrg-$qty;
          $kurangin = $stockskrg + $selisih;
          $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
          $updatenya = mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima' where idkeluar='$idk'");
              if($kurangistocknya&&$updatenya){
                echo '
                <script>
                    alert("Berhasil Mengedit Data !");
                    window.location.href="keluar.php";
                </script>
                ';
                } else {
                    echo '
                    <script>
                        alert("Gagal Mengedit Data !");
                        window.location.href="keluar.php";
                    </script>
                    ';
              }
      }
  }
  
//menghapus barang keluar
  if(isset($_POST['hapusbarangkeluar'])){
      $idb = $_POST['idb'];
      $qty = $_POST['kty'];
      $idk = $_POST['idk'];

      $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
      $data = mysqli_fetch_array($getdatastock);
      $stok = $data['stock'];

      $selisih = $stok+$qty;

      $update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idb'");
      $hapusdata = mysqli_query($conn, "delete from keluar where idkeluar='$idk'");

      if($update&&$hapusdata){
        echo '
        <script>
            alert("Berhasil Menghapus Data !");
            window.location.href="keluar.php";
        </script>
        ';
      } else {
        echo '
        <script>
            alert("Gagal Menghapus Data !");
            window.location.href="keluar.php";
        </script>
        ';
      }

  }
  

// Menambah admin baru
if (isset($_POST['addadmin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cek apakah email sudah ada di database
    $queryCheckEmail = mysqli_query($conn, "SELECT * FROM login WHERE email = '$email'");
    
    // Jika email sudah ada
    if (mysqli_num_rows($queryCheckEmail) > 0) {
        echo '
        <script>
            alert("Email sudah terdaftar!");
            window.location.href="admin.php";
        </script>
        ';
    } else {
        // Hash password sebelum disimpan ke database
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $queryinsert = mysqli_query($conn, "INSERT INTO login (email, password) VALUES ('$email', '$hashedPassword')");

        if ($queryinsert) {
            // Jika berhasil
            echo '
            <script>
                alert("Berhasil Menambah Admin !");
                window.location.href="admin.php";
            </script>
            ';
        } else {
            // Jika gagal insert ke db
            echo '
            <script>
                alert("Gagal Menambah Admin !");
                window.location.href="admin.php";
            </script>
            ';
        }
    }
}




// Edit data admin
if (isset($_POST['updateadmin'])) {
    $emailbaru = $_POST['emailadmin'];
    $passwordbaru = $_POST['passwordbaru'];
    $idnya = $_POST['id'];

    // Jika password baru tidak kosong, hash password baru
    if (!empty($passwordbaru)) {
        $hashedPassword = password_hash($passwordbaru, PASSWORD_BCRYPT);
        // Update email dan password
        $queryupdate = mysqli_query($conn, "UPDATE login SET email='$emailbaru', password='$hashedPassword' WHERE iduser='$idnya'");
    } else {
        // Jika password baru kosong, hanya update email
        $queryupdate = mysqli_query($conn, "UPDATE login SET email='$emailbaru' WHERE iduser='$idnya'");
    }

    if ($queryupdate) {
        echo '
        <script>
            alert("Berhasil Mengedit Data Admin !");
            window.location.href="admin.php";
        </script>
        ';
    } else {
        echo '
        <script>
            alert("Gagal Mengedit Admin !");
            window.location.href="admin.php";
        </script>
        ';
    }
}


//hapus admin
  if(isset($_POST['hapusadmin'])){
    $id = $_POST['id'];

    $querydelete = mysqli_query($conn, "delete from login where iduser='$id'");

    if($querydelete){
        echo '
        <script>
            alert("Berhasil Menghapus Admin !");
            window.location.href="admin.php";
        </script>
        ';
    } else {
        echo '
        <script>
            alert("Gagal Menghapus Admin !");
            window.location.href="admin.php";
        </script>
        ';
    }
  }

//meminjam barang
  if(isset($_POST['pinjam'])){
    $idbarang = $_POST['barangnya']; //untuk mengambil id barangnya
    $qty = $_POST['qty']; //mengambil jumlah qty
    $penerima = $_POST['penerima']; //mengambil nama penerima

    //ambil stock sekarang
    $stok_saat_ini = mysqli_query($conn, "select * from stock where idbarang='$idbarang'");
    $stok_nya = mysqli_fetch_array($stok_saat_ini);
    $stok = $stok_nya['stock']; //ini value nya

    //kurangin stocknya
    $new_stock = $stok-$qty;

    //mulai query insert
    $insertpinjam = mysqli_query($conn,"INSERT INTO peminjaman (idbarang,qty,peminjam) values ('$idbarang','$qty','$penerima')");

    //mengurangi stock di table stock
    $kurangistok = mysqli_query($conn, "update stock set stock='$new_stock' where idbarang='$idbarang'");

    if($insertpinjam&&$kurangistok){
        //jika berhasil
        echo '
        <script>
            alert("Berhasil Menambahkan Data !");
            window.location.href="peminjaman.php";
        </script>
        ';
    } else {
        //jika gagal
        echo '
        <script>
            alert("Gagal Mendambahkan Data !");
            window.location.href="peminjaman.php";
        </script>
        ';
    }
  }

//menyelesaikan pinjaman
  if(isset($_POST['barangkembali'])){
    $idpinjam = $_POST['idpinjam'];
    $idbarang = $_POST['idbarang'];

    //eksekusi
    $update_status =mysqli_query($conn, "update peminjaman set status='Kembali' where idpeminjaman='$idpinjam'");

    //ambil stock sekarang
    $stok_saat_ini = mysqli_query($conn, "select * from stock where idbarang='$idbarang'");
    $stok_nya = mysqli_fetch_array($stok_saat_ini);
    $stok = $stok_nya['stock']; //ini value nya

     //ambil qty dari si idpinjam sekarang
     $stok_saat_ini1 = mysqli_query($conn, "select * from peminjaman where idpeminjaman='$idpinjam'");
     $stok_nya1 = mysqli_fetch_array($stok_saat_ini1);
     $stok1 = $stok_nya1['qty']; //ini value nya

    //kurangin stocknya
    $new_stock = $stok1+$stok;

    //kembalikan stocknya
    $kembalikan_stock = mysqli_query($conn, "update stock set stock='$new_stock' where idbarang='$idbarang'");

    if($update_status&&$kembalikan_stock){
        //jika berhasil
        echo '
        <script>
            alert("Barang Sudah Dikembalikan !");
            window.location.href="peminjaman.php";
        </script>
        ';
    } else {
        //jika gagal
        echo '
        <script>
            alert("Gagal , silahkan ulangi !");
            window.location.href="peminjaman.php";
        </script>
        ';
    }
  }
  
  ?>