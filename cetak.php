<?php
require 'layout/koneksi.php';
$id = $_GET['cetak'];

$data = $conn->query("SELECT * FROM pesanan WHERE id = '$id'");
$data = $data->fetch_object();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>-</title>
</head>

<style>
  h3,
  h2 {
    text-align: center;
  }

  table.table td {
    text-align: center;
  }
</style>

<body>

  <h2>RADENJOYO PRINTING</h2>

  <?php if ($_GET['type'] == "pembayaran") : ?>
    <h3>Plan Order</h3>
  <?php else : ?>
    <h3>Nota Pembayaran</h3>
  <?php endif; ?>

  <table border="0">
    <tr>
      <td style="padding-right: 20px;">Nama Pembeli</td>
      <td>: <?= $data->nama ?></td>
    </tr>
    <tr>
      <td>Alamat Pembeli</td>
      <td>: <?= $data->alamat ?></td>
    </tr>
  </table>

  <br>
  <br>
  <table border="1" style="border-collapse: collapse; width: 100%" class="table">
    <tr>
      <td>Barang</td>
      <td>Harga</td>
      <td>Jumlah</td>
      <td>Total Pembayaran</td>
    </tr>
    <tr>
      <td><?= $data->barang ?></td>
      <td>Rp. <?= number_format($data->harga) ?></td>
      <td><?= $data->jumlah ?></td>
      <td>Rp. <?= number_format($data->harga * $data->jumlah) ?></td>
    </tr>
  </table>

  <br>
  <?php if ($_GET['type'] == "pembayaran") : ?>
    <p>Note : Gunakan Olan Order ini untuk melakukan pembayaran</p>
  <?php endif; ?>

</body>

<script>
  print();
  setTimeout(() => {
    location.replace('data-pesanan.php');
  }, 3000)
</script>

</html>