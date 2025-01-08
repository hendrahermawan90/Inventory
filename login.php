<?php
require 'function.php';

if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Mencari user berdasarkan email
  $cekdatabase = mysqli_query($conn, "SELECT * FROM login WHERE email='$email'");
  $user = mysqli_fetch_assoc($cekdatabase);

  // Memeriksa apakah user ada dan verifikasi password menggunakan password_verify()
  if ($user && password_verify($password, $user['password'])) {
    // Jika password cocok, set session dan redirect ke halaman index
    $_SESSION['log'] = 'True';
    header('location:index.php');
  } else {
    // Jika password tidak cocok, tampilkan pesan error
    $_SESSION['login_failed'] = "Email atau password salah"; // Menyimpan pesan error
    header('location:login.php'); // Arahkan kembali ke halaman login
    exit();
  }
}

if (isset($_SESSION['log'])) {
  header('location:index.php'); // Jika sudah login, arahkan ke halaman index
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
    <title>Login</title>
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
                    <h3 class="text-center font-weight-light my-4">Login</h3>
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
                      <!-- Tombol Login -->
                      <button class="btn btn-primary" name="login">Login</button>
                    </form>
                    <br>
                    <!-- Link menuju halaman register -->
                    <div class="text-center">
                      <a href="register.php" class="small">Belum punya akun? Daftar di sini</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>

    <!-- Notifikasi jika login gagal -->
    <?php if (isset($_SESSION['login_failed'])): ?>
    <script type="text/javascript">
      alert("<?php echo $_SESSION['login_failed']; ?>"); // Menampilkan pesan dari session
      <?php unset($_SESSION['login_failed']); ?> // Menghapus pesan setelah ditampilkan
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
    <script src="js/scripts.js"></script>

    <!-- Script untuk toggle password -->
    <script type="text/javascript">
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
