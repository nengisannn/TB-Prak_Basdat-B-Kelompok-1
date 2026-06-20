<?php

require_once "../config/koneksi.php";

$id = $_GET['id'];

$transaksi = mysqli_fetch_assoc(

    mysqli_query(
        $koneksi,
        "SELECT * FROM transaksi
        WHERE id_transaksi='$id'"
    )

);

$detail = mysqli_query(

    $koneksi,

    "SELECT
        d.*,
        b.nama_barang
    FROM detail_transaksi d
    JOIN barang b
    ON d.id_barang=b.id_barang
    WHERE d.id_transaksi='$id'"

);

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Detail Transaksi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="card">

<div class="card-header bg-primary text-white">

<h3>

Detail Transaksi #<?= $id; ?>

</h3>

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

<th>Tanggal</th>

<td>

<?= $transaksi['tanggal']; ?>

</td>

</tr>

<tr>

<th>Total Belanja</th>

<td>

Rp <?= number_format($transaksi['total_belanja']); ?>

</td>

</tr>

<tr>

<th>Bayar</th>

<td>

Rp <?= number_format($transaksi['bayar']); ?>

</td>

</tr>

<tr>

<th>Kembalian</th>

<td>

Rp <?= number_format($transaksi['kembalian']); ?>

</td>

</tr>

</table>

<h5>Daftar Produk</h5>

<table class="table table-striped">

<thead>

<tr>

<th>Produk</th>
<th>Jumlah</th>
<th>Subtotal</th>

</tr>

</thead>

<tbody>

<?php while($d=mysqli_fetch_assoc($detail)){ ?>

<tr>

<td><?= $d['nama_barang']; ?></td>

<td><?= $d['jumlah']; ?></td>

<td>

Rp <?= number_format($d['subtotal']); ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

<a href="index.php"
class="btn btn-secondary">

Kembali

</a>

</div>

</div>

</div>

</body>

</html>