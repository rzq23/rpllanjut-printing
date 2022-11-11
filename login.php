<?php
session_start();
$hal = "Login";
$error = false;
$success = false;

if (isset($_POST['login'])) {
  require 'layout/koneksi.php';
  $username = htmlspecialchars($_POST['username']);
  $password = htmlspecialchars($_POST['password']);

  $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password' LIMIT 1";
  $res = $conn->query($sql);

  if ($res->num_rows) {
    $login = mysqli_fetch_object($res);

    $success = true;
    $_SESSION['login'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $login->role;
  } else {
    $error = true;
  }
}
?>
<?php require 'layout/header.php'; ?>

<style>
  .row.h-100 {
    background: url('img/login.jpg');
    background-position: center;
    background-size: cover;
  }

  .bg-light {
    background: rgba(242, 246, 250, 0.75) !important;
    box-shadow: .25rem .25rem .5rem rgba(0, 0, 0, 0.21);

  }
</style>

<div class="container-fluid">
  <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-5">
      <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <a href="index.html" class="">
            <h5 class="text-primary"><i class="fa fa-hashtag me-2"></i>RadenJoyo Printing</h5>
          </a>
          <h5>Login</h5>
        </div>

        <form action="" method="POST">
          <div class="form-group mb-3">
            <label for="floatingInput">Username</label>
            <input type="text" class="form-control" id="floatingInput" placeholder="" name="username">
          </div>

          <div class="form-group mb-4">
            <label for="floatingPassword">Password</label>
            <input type="password" class="form-control" id="floatingPassword" placeholder="" name="password">
          </div>

          <button type="submit" name="login" class="btn btn-primary py-2 w-100 mb-4">Login</button>

        </form>
      </div>
    </div>
  </div>
</div>

<?php if ($error) : ?>
  <script>
    alert('Username atau password salah!');
  </script>
<?php endif; ?>

<?php if ($success) : ?>
  <script>
    alert('Login Berhasil');

    <?php if ($_SESSION['role'] == "penjualan" || $_SESSION['role'] == "desainer" || $_SESSION['role'] == "kasir") : ?>
      location.href = 'data-pesanan.php';
    <?php else : ?>
      location.href = 'dashboard.php';
    <?php endif; ?>
  </script>
<?php endif; ?>

<?php require 'layout/footer.php'; ?>