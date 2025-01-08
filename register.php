<?php
require 'function.php';

if (isset($_POST['register'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Hash password menggunakan password_hash()
  $hashed_password = password_hash($password, PASSWORD_BCRYPT);

  // Cek apakah email sudah terdaftar
  $cekdatabase = mysqli_query($conn, "SELECT * FROM login WHERE email='$email'");
  $hitung = mysqli_num_rows($cekdatabase);

  if ($hitung > 0) {
    $_SESSION['register_failed'] = "Email sudah terdaftar"; // Pesan jika email sudah ada
  } else {
    // Menyimpan data pengguna baru ke database dengan password yang sudah di-hash
    $insert = mysqli_query($conn, "INSERT INTO login (email, password) VALUES ('$email', '$hashed_password')");
    if ($insert) {
      $_SESSION['register_success'] = "Akun berhasil dibuat, silakan login!";
      header('location:login.php'); // Arahkan ke halaman login setelah registrasi sukses
      exit();
    } else {
      $_SESSION['register_failed'] = "Terjadi kesalahan saat mendaftar. Coba lagi.";
    }
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
    <title>Register</title>
    <link rel="icon" href="assets/img/icon.png" type="image/x-icon">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
  </head>
  <body class="bg-primary">
    <div id="layoutAuthentication">
      <div id="layoutAuthentication_content">
        <main>
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                  <div class="card-header">
                    <h3 class="text-center font-weight-light my-4">Register</h3>
                  </div>
                  <div class="card-body">
                    <form method="post">
                      <!-- Input untuk email -->
                      <div class="form-group">
                        <label class="small mb-1" for="inputEmailAddress">Email</label>
                        <input class="form-control py-4" name="email" id="inputEmailAddress" type="email" placeholder="Enter email address" required />
                      </div>
                      <!-- Input untuk password -->
                      <div class="form-group">
                        <label class="small mb-1" for="inputPassword">Password</label>
                        <div class="input-group">
                          <input class="form-control py-4" name="password" id="inputPassword" type="password" placeholder="Enter password" required />
                          <div class="input-group-append">
                            <span class="input-group-text" id="togglePassword">
                              <i class="fas fa-eye" id="eye-icon"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                      <!-- Tombol Register -->
                      <button class="btn btn-primary" name="register">Register</button>
                    </form>
                    <br>
                    <!-- Link menuju halaman login -->
                    <div class="text-center">
                      <a href="login.php" class="small">Sudah punya akun? Login di sini</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>

    <!-- Notifikasi jika register gagal -->
    <?php if (isset($_SESSION['register_failed'])): ?>
    <script type="text/javascript">
      alert("<?php echo $_SESSION['register_failed']; ?>");
      <?php unset($_SESSION['register_failed']); ?>
    </script>
    <?php endif; ?>

    <!-- Notifikasi jika register sukses -->
    <?php if (isset($_SESSION['register_success'])): ?>
    <script type="text/javascript">
      alert("<?php echo $_SESSION['register_success']; ?>");
      <?php unset($_SESSION['register_success']); ?>
    </script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- Script untuk toggle password -->
    <script type="text/javascript">
      // Menambahkan event listener untuk ikon mata
      document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordField = document.getElementById('inputPassword');
        const eyeIcon = document.getElementById('eye-icon');
        
        // Toggle password visibility
        if (passwordField.type === "password") {
          passwordField.type = "text";
          eyeIcon.classList.remove("fa-eye");
          eyeIcon.classList.add("fa-eye-slash");
        } else {
          passwordField.type = "password";
          eyeIcon.classList.remove("fa-eye-slash");
          eyeIcon.classList.add("fa-eye");
        }
      });
    </script>
  </body>
</html>
