<?php

require_once "../config/koneksi.php";

$id = $_GET['id'];
$status = $_GET['status'];

mysqli_query(
    $koneksi,
    "UPDATE transaksi
    SET status='$status'
    WHERE id_transaksi='$id'"
);

header("Location:index.php");
exit;