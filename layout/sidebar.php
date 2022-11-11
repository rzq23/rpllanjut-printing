<div class="sidebar pe-4 pb-3">
  <nav class="navbar bg-light navbar-light">
    <a href="index.html" class="navbar-brand mx-4 mb-3">
      <h5 class="text-primary"><i class="fa fa-hashtag me-2"></i>RadenJoyo Printing</h5>
    </a>
    <div class="d-flex align-items-center ms-4 mb-4">
      <div class="position-relative">
      </div>
      <div class="ms-3">
        <h6 class="mb-0">Login :</h6>
        <span><?= $_SESSION['username'] ?></span>
      </div>
    </div>
    <div class="navbar-nav w-100">
      <?php if ($_SESSION['role'] == "owner" || $_SESSION['role'] == "manager") : ?>
        <a href="dashboard.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
      <?php endif; ?>

      <a href="data-pesanan.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Data Pesanan</a>
      <?php if ($_SESSION['role'] == "penjualan") : ?>
        <a href="data-pembayaran.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Data Pembayaran</a>
      <?php endif; ?>

    </div>
  </nav>
</div>