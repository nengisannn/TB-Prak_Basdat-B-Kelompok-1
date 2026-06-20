<?php
$koneksi = new mysqli("localhost","root","","db_kasir");

if ($koneksi->connect_error) {
    die("Koneksi gagal");
}

/* CARD */

$totalProduk = $koneksi->query("
SELECT COUNT(*) total
FROM barang
")->fetch_assoc()['total'];

$totalStok = $koneksi->query("
SELECT SUM(stok) total
FROM barang
")->fetch_assoc()['total'];

$totalTransaksi = $koneksi->query("
SELECT COUNT(*) total
FROM transaksi
")->fetch_assoc()['total'];

$totalPendapatan = $koneksi->query("
SELECT SUM(total_belanja) total
FROM transaksi
")->fetch_assoc()['total'];

/* CHART PENJUALAN BULANAN */

$chart = [];

$qChart = $koneksi->query("
SELECT
DATE_FORMAT(tanggal,'%b') bulan,
SUM(total_belanja) total
FROM transaksi
GROUP BY MONTH(tanggal)
ORDER BY MONTH(tanggal)
");

while($r = $qChart->fetch_assoc()){
    $chart[] = $r;
}

/* PRODUK TERLARIS */

$produkTerlaris = $koneksi->query("
SELECT
barang.nama_barang,
SUM(detail_transaksi.jumlah) total_terjual
FROM detail_transaksi
JOIN barang
ON barang.id_barang = detail_transaksi.id_barang
GROUP BY barang.id_barang
ORDER BY total_terjual DESC
LIMIT 5
");

/* STOK MENIPIS */

$stokMenipis = $koneksi->query("
SELECT *
FROM barang
WHERE stok <= 10
ORDER BY stok ASC
");

/* PEMBAYARAN */

$pembayaran = [];

$qBayar = $koneksi->query("
SELECT
metode,
COUNT(*) jumlah
FROM pembayaran
GROUP BY metode
");

while($r = $qBayar->fetch_assoc()){
    $pembayaran[] = $r;
}

/* TRANSAKSI TERBARU */

$transaksi = $koneksi->query("
SELECT *
FROM transaksi
ORDER BY id_transaksi DESC
LIMIT 10
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Kasir</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

/* 🌸 GLOBAL BACKGROUND */
body{
    background: linear-gradient(
        135deg,
        #fff5f8 0%,
        #ffe4ec 40%,
        #fce7f3 70%,
        #ffffff 100%
    );
    min-height:100vh;
    font-family: Arial, sans-serif;
}

/* CARD */
.card-dashboard{
    border:none;
    border-radius:15px;
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 25px rgba(255, 182, 193, 0.25);
}

/* TITLE */
h2, .card-header{
    color:#d63384;
    font-weight:600;
}

/* NUMBER */
.card-number{
    font-size:30px;
    font-weight:bold;
    color:#d63384;
}

/* TABLE */
.table{
    font-size:14px;
    background:white;
    border-radius:10px;
    overflow:hidden;
}

.table thead{
    background:#ffe4ec;
    color:#d63384;
}

/* BADGE */
.badge-success{
    background: linear-gradient(135deg, #f472b6, #ec4899);
    padding:10px 15px;
    border-radius:15px;
    color:white;
}

/* BUTTON */
.btn-transaksi{
    background: linear-gradient(135deg, #ff8fb1, #f7a8c4);
    border:none;
    color:white;
    font-weight:600;
    border-radius:15px;
    padding:12px 20px;
}

.btn-transaksi:hover{
    background: linear-gradient(135deg, #ff6f9c, #f472b6);
}

</style>

</head>

<body>

<div class="container-fluid p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            Dashboard Kasir
        </h2>

        <a href="tambah.php" class="btn btn-transaksi">
            Tambah Transaksi
        </a>

    </div>

    <div class="row mb-4">

        <div class="col-md-3">
            <div class="card card-dashboard">
                <div class="card-body">
                    <h6>Total Produk</h6>
                    <div class="card-number"><?= number_format($totalProduk) ?></div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-dashboard">
                <div class="card-body">
                    <h6>Total Stok</h6>
                    <div class="card-number"><?= number_format($totalStok) ?></div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-dashboard">
                <div class="card-body">
                    <h6>Total Transaksi</h6>
                    <div class="card-number"><?= number_format($totalTransaksi) ?></div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-dashboard">
                <div class="card-body">
                    <h6>Total Pendapatan</h6>
                    <div class="card-number">Rp <?= number_format($totalPendapatan) ?></div>
                </div>
            </div>
        </div>

    </div>

    <div class="row mb-4">

        <div class="col-md-8">
            <div class="card card-dashboard">
                <div class="card-header">Penjualan Bulanan</div>
                <div class="card-body">
                    <canvas id="chartPenjualan"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-dashboard">
                <div class="card-header">Metode Pembayaran</div>
                <div class="card-body">
                    <canvas id="chartBayar"></canvas>
                </div>
            </div>
        </div>

    </div>

    <div class="row mb-4">

        <div class="col-md-6">
            <div class="card card-dashboard">
                <div class="card-header">Produk Terlaris</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($p = $produkTerlaris->fetch_assoc()){ ?>
                            <tr>
                                <td><?= $p['nama_barang'] ?></td>
                                <td><?= $p['total_terjual'] ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-dashboard">
                <div class="card-header">Stok Menipis</div>
                <div class="card-body">
                    <table class="table table-danger">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($s = $stokMenipis->fetch_assoc()){ ?>
                            <tr>
                                <td><?= $s['nama_barang'] ?></td>
                                <td><?= $s['stok'] ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="card card-dashboard">

        <div class="card-header">
            Transaksi Terbaru
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while($t = $transaksi->fetch_assoc()){ ?>
                    <tr>
                        <td><?= $t['id_transaksi'] ?></td>
                        <td><?= $t['tanggal'] ?></td>
                        <td>Rp <?= number_format($t['total_belanja']) ?></td>
                    </tr>
                    <?php } ?>
                </tbody>

            </table>

        </div>

    </div>

</div>

<script>

/* PENJUALAN */
const chartPenjualan = new Chart(
document.getElementById('chartPenjualan'),
{
type:'bar',
data:{
labels:[
<?php foreach($chart as $c){ echo "'".$c['bulan']."',"; } ?>
],
datasets:[{
label:'Penjualan',
data:[
<?php foreach($chart as $c){ echo $c['total'].","; } ?>
]
}]
}
});

/* PEMBAYARAN */
const chartBayar = new Chart(
document.getElementById('chartBayar'),
{
type:'pie',
data:{
labels:[
<?php foreach($pembayaran as $p){ echo "'".$p['metode']."',"; } ?>
],
datasets:[{
data:[
<?php foreach($pembayaran as $p){ echo $p['jumlah'].","; } ?>
]
}]
}
});

</script>

</body>
</html>