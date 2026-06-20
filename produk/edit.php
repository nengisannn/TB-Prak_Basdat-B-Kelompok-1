<?php

require_once "../config/koneksi.php";

$id = $_GET['id'];

$data = mysqli_fetch_assoc(
    mysqli_query(
        $koneksi,
        "SELECT * FROM barang
         WHERE id_barang='$id'"
    )
);

if(isset($_POST['update'])){

    $nama = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori = $_POST['id_kategori'];
    $supplier = $_POST['id_supplier'];

    mysqli_query(
        $koneksi,
        "UPDATE barang SET
        nama_barang='$nama',
        harga='$harga',
        stok='$stok',
        id_kategori='$kategori',
        id_supplier='$supplier'
        WHERE id_barang='$id'"
    );

    echo "
    <script>
    alert('Data berhasil diubah');
    window.location='index.php';
    </script>
    ";
}

$kategori = mysqli_query(
    $koneksi,
    "SELECT * FROM kategori"
);

$supplier = mysqli_query(
    $koneksi,
    "SELECT * FROM supplier"
);

?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Produk</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="card">

<div class="card-header">
<h3>Edit Produk</h3>
</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">
<label>Nama Produk</label>
<input
type="text"
name="nama_barang"
class="form-control"
value="<?= $data['nama_barang']; ?>"
required>
</div>

<div class="mb-3">
<label>Harga</label>
<input
type="number"
name="harga"
class="form-control"
value="<?= $data['harga']; ?>"
required>
</div>

<div class="mb-3">
<label>Stok</label>
<input
type="number"
name="stok"
class="form-control"
value="<?= $data['stok']; ?>"
required>
</div>

<div class="mb-3">
<label>Kategori</label>

<select
name="id_kategori"
class="form-select">

<?php while($k=mysqli_fetch_assoc($kategori)){ ?>

<option
value="<?= $k['id_kategori']; ?>"
<?= ($k['id_kategori']==$data['id_kategori']) ? 'selected' : ''; ?>>

<?= $k['nama_kategori']; ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">
<label>Supplier</label>

<select
name="id_supplier"
class="form-select">

<?php while($s=mysqli_fetch_assoc($supplier)){ ?>

<option
value="<?= $s['id_supplier']; ?>"
<?= ($s['id_supplier']==$data['id_supplier']) ? 'selected' : ''; ?>>

<?= $s['nama_supplier']; ?>

</option>

<?php } ?>

</select>

</div>

<button
type="submit"
name="update"
class="btn btn-primary">

Update

</button>

<a href="index.php"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

</body>
</html>