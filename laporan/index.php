<?php

require_once "../config/koneksi.php";

$where = "";

if(isset($_GET['filter'])){

    $dari = $_GET['dari'];
    $sampai = $_GET['sampai'];

    $where = "WHERE tanggal BETWEEN '$dari' AND '$sampai'";
}

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM transaksi
     $where
     ORDER BY id_transaksi DESC"
);

$totalPendapatan = mysqli_fetch_assoc(
    mysqli_query(
        $koneksi,
        "SELECT SUM(total_belanja) as total
         FROM transaksi
         $where"
    )
);

?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Laporan Penjualan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<style>

body{
    font-family:'Poppins',sans-serif;
    background:
    linear-gradient(
        135deg,
        #ffffff,
        #ffe4ec,
        #ffd6e7
    );
}

.card-custom{
    border:none;
    border-radius:20px;
    background:white;
    box-shadow:0 10px 20px rgba(0,0,0,.08);
}

.title{
    color:#db2777;
    font-weight:700;
}

.btn-filter{
    background:#ec4899;
    color:white;
    border:none;
}

.btn-filter:hover{
    background:#db2777;
    color:white;
}

.total-box{

    background:
    linear-gradient(
        135deg,
        #ec4899,
        #f472b6
    );

    color:white;

    border-radius:20px;

    padding:20px;
}

.table thead{
    background:#ffe4ec;
    color:#db2777;
}

</style>

</head>

<body>

<div class="container py-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2 class="title">
📊 Laporan Penjualan
</h2>

<button
onclick="window.print()"
class="btn btn-dark">

<i class="fa fa-print"></i>
 Cetak

</button>

</div>

<div class="card card-custom p-4 mb-4">

<form method="GET">

<div class="row">

<div class="col-md-4">

<label>Dari Tanggal</label>

<input
type="date"
name="dari"
class="form-control"
required>

</div>

<div class="col-md-4">

<label>Sampai Tanggal</label>

<input
type="date"
name="sampai"
class="form-control"
required>

</div>

<div class="col-md-4 d-flex align-items-end">

<button
name="filter"
class="btn btn-filter w-100">

<i class="fa fa-search"></i>
 Filter

</button>

</div>

</div>

</form>

</div>

<div class="total-box mb-4">

<h5>Total Pendapatan</h5>

<h2>
Rp <?= number_format($totalPendapatan['total'] ?? 0); ?>
</h2>

</div>

<div class="card card-custom">

<div class="card-body">

<table class="table table-hover">

<thead>

<tr>

<th>ID</th>
<th>Tanggal</th>
<th>Total</th>
<th>Bayar</th>
<th>Kembalian</th>

</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($query)){ ?>

<tr>

<td>
<?= $row['id_transaksi']; ?>
</td>

<td>
<?= $row['tanggal']; ?>
</td>

<td>
Rp <?= number_format($row['total_belanja']); ?>
</td>

<td>
Rp <?= number_format($row['bayar']); ?>
</td>

<td>
Rp <?= number_format($row['kembalian']); ?>
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</body>
</html>