<?php
session_start();
$hal = "Owner";
$error = false;
$success = false;

if (!isset($_SESSION['login'])) {
  header("location: login.php");
  die;
}

?>
<?php require 'layout/header.php'; ?>

<?php require 'layout/sidebar.php'; ?>

<div class="content">
  <?php require 'layout/navbar.php'; ?>
  <?php require 'layout/koneksi.php'; ?>

  <?php
  $data = $conn->query("SELECT * FROM pesanan ORDER BY id DESC");
  $jlhPesanan = $data->num_rows;


  ?>

  <div class="container-fluid pt-4 px-4">
    <div class="row g-4">
      <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
          <i class="fa fa-chart-line fa-3x text-primary"></i>
          <div class="ms-3">
            <p class="mb-2">Total Pemesanan</p>

            <h6 class="mb-0"><?= $jlhPesanan ?></h6>
          </div>
        </div>
      </div>

    </div>
  </div>

</div>


<?php require 'layout/footer.php'; ?>