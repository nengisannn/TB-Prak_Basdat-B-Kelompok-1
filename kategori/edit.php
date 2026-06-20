<?php

require_once "../config/koneksi.php";

$id = (int)$_GET['id'];

$data = mysqli_fetch_assoc(
    mysqli_query(
        $koneksi,
        "SELECT *
        FROM kategori
        WHERE id_kategori='$id'"
    )
);

if(isset($_POST['update'])){

    $nama = mysqli_real_escape_string(
        $koneksi,
        $_POST['nama_kategori']
    );

    mysqli_query(
        $koneksi,
        "UPDATE kategori
        SET nama_kategori='$nama'
        WHERE id_kategori='$id'"
    );

    echo "
    <script>
    alert('Kategori berhasil diubah');
    window.location='index.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Kategori</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="card">

<div class="card-header">
Edit Kategori
</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label>Nama Kategori</label>

<input
type="text"
name="nama_kategori"
class="form-control"
value="<?= $data['nama_kategori']; ?>"
required>

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