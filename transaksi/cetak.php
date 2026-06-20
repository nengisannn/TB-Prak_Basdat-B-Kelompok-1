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

<title>Cetak Struk</title>

<style>

body{
    width:300px;
    margin:auto;
    font-family:monospace;
}

.center{
    text-align:center;
}

</style>

</head>

<body onload="window.print()">

<div class="center">

<h3>TOKO KASIR</h3>

<p>Terima Kasih Telah Berbelanja</p>

</div>

<hr>

<p>

No Transaksi :
<?= $transaksi['id_transaksi']; ?>

</p>

<p>

Tanggal :
<?= $transaksi['tanggal']; ?>

</p>

<hr>

<?php while($d=mysqli_fetch_assoc($detail)){ ?>

<p>

<?= $d['nama_barang']; ?>

<br>

<?= $d['jumlah']; ?>

x

Rp <?= number_format($d['subtotal']); ?>

</p>

<?php } ?>

<hr>

<h4>

Total :

Rp <?= number_format($transaksi['total_belanja']); ?>

</h4>

<p>

Bayar :

Rp <?= number_format($transaksi['bayar']); ?>

</p>

<p>

Kembalian :

Rp <?= number_format($transaksi['kembalian']); ?>

</p>

<hr>

<div class="center">

Terima Kasih 😊

</div>

</body>

</html>