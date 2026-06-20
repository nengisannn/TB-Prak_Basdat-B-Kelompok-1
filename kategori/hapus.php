<?php

require_once "../config/koneksi.php";

$id = (int)$_GET['id'];

$cek = mysqli_query(
    $koneksi,
    "SELECT *
    FROM barang
    WHERE id_kategori='$id'"
);

if(mysqli_num_rows($cek) > 0){

    echo "
    <script>
    alert('Kategori masih digunakan oleh produk!');
    window.location='index.php';
    </script>
    ";
    exit;
}

mysqli_query(
    $koneksi,
    "DELETE FROM kategori
    WHERE id_kategori='$id'"
);

echo "
<script>
alert('Kategori berhasil dihapus');
window.location='index.php';
</script>
";