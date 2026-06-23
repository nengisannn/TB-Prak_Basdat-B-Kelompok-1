<?php

require_once "../config/koneksi.php";

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM barang ORDER BY id_barang DESC"
);

?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Data Produk</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

body{
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg,#ffffff,#ffe4ec,#ffd6e7);
    min-height: 100vh;
    color:#334155;
}

/* BUTTON BACK TO DASHBOARD */
.btn-back{
    background: white;
    color:#db2777;
    border: 2px solid #ff8fb1;
    border-radius: 12px;
    padding: 10px 20px;
    font-weight: 600;
    transition: .3s;
    text-decoration: none;
    display: inline-block;
    box-shadow: 0 5px 15px rgba(255, 182, 193, .15);
}

.btn-back:hover{
    background: #fff1f5;
    border-color: #db2777;
    color:#db2777;
    transform:translateY(-2px);
}

/* HEADER */
.header-card{
    background: rgba(255,255,255,.9);
    backdrop-filter: blur(10px);
    border-radius: 18px;
    padding: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,.08);
}

/* TABLE CARD */
.table-card{
    background: white;
    border-radius: 18px;
    padding: 20px;
    margin-top: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,.06);
}

/* TITLE */
.title{
    font-weight: 700;
    color:#db2777;
    margin-bottom: 0;
}

/* TABLE */
.table{
    background:white;
    border-radius: 12px;
    overflow: hidden;
    color:#334155;
}

.table thead{
    background:#ffe4ec;
    color:#db2777;
}

.table tbody tr:hover{
    background:#fff1f5;
    transition:.2s;
}

/* BADGE STOCK */
.badge-low{
    background:#fb7185;
    padding:5px 10px;
    border-radius:20px;
    color:white;
}

.badge-ok{
    background:#34d399;
    padding:5px 10px;
    border-radius:20px;
    color:white;
}

/* BUTTON */
.btn-custom{
    border-radius: 10px;
    font-weight: 500;
}

.btn-add{
    background:#ec4899;
    color:white;
}

.btn-add:hover{
    background:#db2777;
    color:white;
}

.btn-edit{
    background:#60a5fa;
    color:white;
}

.btn-delete{
    background:#fb7185;
    color:white;
}

</style>

</head>

<body>

<div class="container py-4">

<div class="mb-4">
    <a href="../dashboard/index.php" class="btn-back">
        <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Dashboard
    </a>
</div>

<div class="header-card d-flex justify-content-between align-items-center">

<h3 class="title">
📦 Data Produk
</h3>

<a href="tambah.php" class="btn btn-add btn-custom">
<i class="fa fa-plus"></i> Tambah Produk
</a>

</div>

<div class="table-card">

<table class="table table-hover align-middle mb-0">

<thead>
<tr>
<th>No</th>
<th>Nama Produk</th>
<th>Harga</th>
<th>Stok</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

<?php $no=1; while($row=mysqli_fetch_assoc($query)){ ?>

<tr>

<td><?= $no++; ?></td>

<td class="fw-semibold">
<?= $row['nama_barang']; ?>
</td>

<td>
Rp <?= number_format($row['harga']); ?>
</td>

<td>

<?php if($row['stok'] <= 10){ ?>

<span class="badge-low">
<?= $row['stok']; ?>
</span>

<?php } else { ?>

<span class="badge-ok">
<?= $row['stok']; ?>
</span>

<?php } ?>

</td>

<td>

<a href="edit.php?id=<?= $row['id_barang']; ?>"
class="btn btn-edit btn-sm btn-custom">
<i class="fa fa-edit"></i>
</a>

<a href="hapus.php?id=<?= $row['id_barang']; ?>"
class="btn btn-delete btn-sm btn-custom"
onclick="return confirm('Hapus produk ini?')">
<i class="fa fa-trash"></i>
</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</body>
</html>