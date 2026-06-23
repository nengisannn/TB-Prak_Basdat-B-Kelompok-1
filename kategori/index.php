<?php

require_once "../config/koneksi.php";

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM kategori
     ORDER BY id_kategori DESC"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Data Kategori</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<style>

*{
    font-family:'Poppins',sans-serif;
}

body{
    background:
    linear-gradient(
        135deg,
        #fff,
        #ffe4ec,
        #ffd6e7
    );
    min-height:100vh;
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

    background:white;

    border-radius:25px;

    padding:25px;

    box-shadow:
    0 10px 30px rgba(236,72,153,.15);

    margin-bottom:20px;
}

.title{

    color:#db2777;

    font-weight:700;
}

/* TABLE CARD */
.table-card{

    background:white;

    border-radius:25px;

    padding:25px;

    box-shadow:
    0 10px 30px rgba(236,72,153,.15);
}

/* TABLE */
.table thead{

    background:#fbcfe8;

    color:#be185d;
}

.table tbody tr:hover{

    background:#fff1f5;
}

/* BUTTON */
.btn-add{

    background:#ec4899;

    color:white;

    border:none;

    border-radius:12px;

    padding:10px 18px;
}

.btn-add:hover{

    background:#db2777;

    color:white;
}

.btn-edit{

    background:#f9a8d4;

    color:white;

    border:none;
}

.btn-edit:hover{

    background:#ec4899;

    color:white;
}

.btn-delete{

    background:#fb7185;

    color:white;

    border:none;
}

.btn-delete:hover{

    background:#e11d48;

    color:white;
}

.badge-custom{

    background:#fce7f3;

    color:#be185d;

    padding:8px 15px;

    border-radius:20px;

    font-size:13px;
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

<div class="header-card">

<div class="d-flex justify-content-between align-items-center">

<div>

<h2 class="title">
🏷️ Data Kategori
</h2>

<p class="text-muted mb-0">
Kelola kategori produk toko Anda
</p>

</div>

<a href="tambah.php"
class="btn btn-add">

<i class="fa fa-plus"></i>

Tambah Kategori

</a>

</div>

</div>

<div class="table-card">

<div class="table-responsive">

<table class="table align-middle">

<thead>

<tr>

<th width="10%">
No
</th>

<th>
Nama Kategori
</th>

<th width="25%">
Aksi
</th>

</tr>

</thead>

<tbody>

<?php

$no = 1;

while($row = mysqli_fetch_assoc($query)){

?>

<tr>

<td>
<?= $no++; ?>
</td>

<td>

<span class="badge-custom">

<?= $row['nama_kategori']; ?>

</span>

</td>

<td>

<a
href="edit.php?id=<?= $row['id_kategori']; ?>"
class="btn btn-edit btn-sm">

<i class="fa fa-edit"></i>

Edit

</a>

<a
href="hapus.php?id=<?= $row['id_kategori']; ?>"
class="btn btn-delete btn-sm"
onclick="return confirm('Yakin ingin menghapus kategori ini?')">

<i class="fa fa-trash"></i>

Hapus

</a>

</td>

</tr>

<?php } ?>

<?php

if(mysqli_num_rows($query) == 0){

?>

<tr>

<td colspan="3" class="text-center">

Belum ada data kategori

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