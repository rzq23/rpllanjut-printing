<?php
session_start();
$hal = "Data Pesanan";
$error = false;
$success = false;

if (!isset($_SESSION['login'])) {
  header("location: login.php");
  die;
}

if (isset($_POST['add'])) {
  require 'layout/koneksi.php';
  $pembeli = htmlspecialchars($_POST['pembeli']);
  $alamat = htmlspecialchars($_POST['alamat']);
  $barang = htmlspecialchars($_POST['barang']);
  $harga = htmlspecialchars($_POST['harga']);
  $jumlah = htmlspecialchars($_POST['jumlah']);

  $sql = "INSERT INTO pesanan VALUES('', '$pembeli', '$alamat', '$barang', '$harga', '$jumlah', '0', '0', '0')";

  if ($conn->query($sql)) {
    $success = true;
  } else {
    $error = true;
  }
}

?>
<?php require 'layout/header.php'; ?>

<?php require 'layout/sidebar.php'; ?>

<div class="content">
  <?php require 'layout/navbar.php'; ?>

  <div class="container-fluid pt-4 px-4">
    <div class="row g-4">
      <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
          <h6 class="mb-4">Tambah Data Pesanan</h6>

          <form action="" method="POST">
            <div class="mb-3">
              <label for="pembeli" class="form-label">Pembeli</label>
              <input type="text" class="form-control" id="pembeli" name="pembeli" required>
            </div>
            <div class="mb-3">
              <label for="alamat" class="form-label">Alamat</label>
              <input type="text" class="form-control" id="alamat" name="alamat" required>
            </div>
            <div class="mb-3">
              <label for="barang" class="form-label">Barang</label>
              <input type="text" class="form-control" id="barang" name="barang" required>
            </div>
            <div class="mb-3">
              <label for="harga" class="form-label">Harga</label>
              <input type="number" class="form-control" id="harga" name="harga" required>
            </div>
            <div class="mb-3">
              <label for="jumlah" class="form-label">Jumlah</label>
              <input type="number" class="form-control" id="jumlah" name="jumlah" required>
            </div>

            <button type="submit" name="add" class="btn btn-primary">Tambah</button>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>
</div>

<?php if ($error) : ?>
  <script>
    alert('Data Gagal Ditambah!');
  </script>
<?php endif; ?>

<?php if ($success) : ?>
  <script>
    alert('Data Berhasil Ditambah!');
    location.href = 'data-pesanan.php';
  </script>
<?php endif; ?>


<?php require 'layout/footer.php'; ?>