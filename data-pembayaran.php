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

if (isset($_GET['pengambilan'])) {
  $sql = "UPDATE pesanan SET pengambilan = '1' WHERE id = '$_GET[pengambilan]'";
  $conn->query($sql);


  header("location: data-pembayaran.php");
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
          <h6 class="mb-4">Data Pesanan Yang Sudah Dibayar</h6>

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
                  <th scope="col">Status Pembayaran</th>
                  <th scope="col">Status Pembuatan</th>
                  <th scope="col">Status Pengambilan</th>
                  <th scope="col">Konfirmasi Pengambilan</th>
              </thead>
              <tbody>
                <?php
                $res = $conn->query("SELECT * FROM pesanan WHERE pembayaran = '1' ORDER BY id DESC");
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
                      <td>
                        <span class="badge <?= $d->pembayaran != 0 ? "bg-primary" : "bg-danger" ?>">
                          <?= $d->pembayaran != 0 ? "Sudah dibayar" : "Belum dibayar" ?>
                        </span>
                      </td>
                      <td>
                        <span class="badge <?= $d->pembuatan != 0 ? "bg-primary" : "bg-danger" ?>">
                          <?= $d->pembuatan != 0 ? "Selesai pembuatan" : "Proses dibuat" ?>
                        </span>
                      </td>
                      <td>
                        <span class="badge <?= $d->pengambilan != 0 ? "bg-primary" : "bg-danger" ?>">
                          <?= $d->pengambilan != 0 ? "Sudah diambil" : "Belum diambil" ?>
                        </span>
                      </td>
                      <td>
                        <?php if (!$d->pengambilan) : ?>
                          <a href="?pengambilan=<?= $d->id ?>" class="btn btn-sm btn-warning text-white">Sudah Diambil</a>
                        <?php endif; ?>
                      </td>
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