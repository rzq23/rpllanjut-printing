<?php
session_start();
$hal = "Data Pesanan";
$error = false;
$success = false;

if (!isset($_SESSION['login'])) {
  header("location: login.php");
  die;
}

require 'layout/koneksi.php';

if (isset($_GET['hapus'])) {
  $sql = "DELETE FROM pesanan WHERE id = '$_GET[hapus]'";
  $conn->query($sql);


  header("location: data-pesanan.php");
} else if (isset($_GET['pembayaran'])) {
  $sql = "UPDATE pesanan SET pembayaran = '1' WHERE id = '$_GET[pembayaran]'";
  $conn->query($sql);


  header("location: data-pesanan.php");
} else if (isset($_GET['pembuatan'])) {
  $sql = "UPDATE pesanan SET pembuatan = '1' WHERE id = '$_GET[pembuatan]'";
  $conn->query($sql);


  header("location: data-pesanan.php");
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
          <h6 class="mb-4">Data Pesanan</h6>

          <?php if ($_SESSION['role'] == "penjualan") : ?>
            <a href="tambah-pesanan.php" class="btn btn-primary mb-3">+ Pesanan</a>
          <?php endif; ?>


          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Pembeli</th>
                  <th scope="col">Alamat</th>
                  <th scope="col">Barang</th>
                  <th scope="col">Harga</th>
                  <th scope="col">Jumlah</th>
                  <th scope="col">Total Pembayaran</th>
                  <?php if ($_SESSION['role'] != "desainer") : ?>
                    <th scope="col">Status Pembayaran</th>
                  <?php endif; ?>
                  <?php if ($_SESSION['role'] != "kasir" && $_SESSION['role'] != "penjualan") : ?>
                    <th scope="col">Status Pembuatan</th>
                  <?php endif; ?>
                  <?php if ($_SESSION['role'] == "owner" || $_SESSION['role'] == "manager") : ?>
                    <th scope="col">Status Pengambilan</th>
                  <?php endif; ?>
                  <?php if ($_SESSION['role'] == "penjualan" || $_SESSION['role'] == "kasir" || $_SESSION['role'] == "desainer") : ?>
                    <th scope="col">Aksi</th>
                  <?php endif; ?>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($_SESSION['role'] == "penjualan") {
                  $res = $conn->query("SELECT * FROM pesanan WHERE pembayaran = '0' ORDER BY id DESC");
                } else if ($_SESSION['role'] == "kasir") {
                  $res = $conn->query("SELECT * FROM pesanan ORDER BY id DESC");
                } else if ($_SESSION['role'] == "desainer") {
                  $res = $conn->query("SELECT * FROM pesanan WHERE pembayaran = '1' ORDER BY id DESC");
                } else {
                  $res = $conn->query("SELECT * FROM pesanan ORDER BY id DESC");
                }
                $data = [];

                if (!$res->num_rows) {
                  $data = null;
                } else {
                  while ($item = $res->fetch_object()) {
                    $data[] = $item;
                  }
                }
                $i = 1;
                ?>
                <?php if ($data) : ?>
                  <?php foreach ($data as $d) : ?>
                    <tr>
                      <th scope="row"><?= $i ?></th>
                      <td><?= $d->nama ?></td>
                      <td><?= $d->alamat ?></td>
                      <td><?= $d->barang ?></td>
                      <td>Rp<?= number_format($d->harga) ?></td>
                      <td><?= $d->jumlah ?></td>
                      <td>Rp<?= number_format($d->harga * $d->jumlah) ?></td>

                      <?php if ($_SESSION['role'] != "desainer") : ?>
                        <td>
                          <span class="badge <?= $d->pembayaran != 0 ? "bg-primary" : "bg-danger" ?>">
                            <?= $d->pembayaran != 0 ? "Sudah dibayar" : "Belum dibayar" ?>
                          </span>
                        </td>
                      <?php endif; ?>

                      <?php if ($_SESSION['role'] != "kasir" && $_SESSION['role'] != "penjualan") : ?>
                        <td>
                          <span class="badge <?= $d->pembuatan != 0 ? "bg-primary" : "bg-danger" ?>">
                            <?= $d->pembuatan != 0 ? "Selesai pembuatan" : "Proses dibuat" ?>
                          </span>
                        </td>
                      <?php endif; ?>

                      <?php if ($_SESSION['role'] == "owner" || $_SESSION['role'] == "manager") : ?>
                        <td>
                          <span class="badge <?= $d->pengambilan != 0 ? "bg-primary" : "bg-danger" ?>">
                            <?= $d->pengambilan != 0 ? "Sudah diambil" : "Belum diambil" ?>
                          </span>
                        </td>
                      <?php endif; ?>

                      <?php if ($_SESSION['role'] == "penjualan") : ?>
                        <td class="text-center ">
                          <a href="edit-pesanan.php?id=<?= $d->id ?>" class="btn btn-secondary btn-sm mb-2">Edit</a>
                          <br>
                          <a href="?hapus=<?= $d->id ?>" class="btn btn-danger btn-sm mb-2" onclick="return confirm('Apakah Anda Yakin Menghapus?')">Hapus</a>
                          <br>
                          <a href="cetak.php?type=pembayaran&cetak=<?= $d->id ?>" class="btn btn-primary btn-sm">Cetak Plan Order</a>
                        </td>
                      <?php endif; ?>

                      <?php if ($_SESSION['role'] == "kasir") : ?>
                        <td>
                          <?php if (!$d->pembayaran) : ?>
                            <a href="?pembayaran=<?= $d->id ?>" class="btn btn-warning btn-sm text-white">
                              Sudah Melakukan Pembayaran
                            </a>
                          <?php else : ?>
                            <a href="cetak.php?type=&cetak=<?= $d->id ?>" class="btn btn-primary btn-sm">Cetak Nota Pembayaran</a>
                          <?php endif; ?>
                        </td>
                      <?php endif; ?>

                      <?php if ($_SESSION['role'] == "desainer") : ?>
                        <td>
                          <?php if (!$d->pembuatan) : ?>
                            <a href="?pembuatan=<?= $d->id ?>" class="btn btn-warning btn-sm text-white">
                              Barang Sudah Dibuat
                            </a>
                          <?php endif; ?>
                        </td>
                      <?php endif; ?>


                    </tr>
                    <?php $i++ ?>
                  <?php endforeach; ?>
                <?php endif; ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php require 'layout/footer.php'; ?>