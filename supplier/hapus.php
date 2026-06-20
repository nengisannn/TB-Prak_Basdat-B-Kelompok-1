<?php

require_once "../config/koneksi.php";

if(isset($_GET['id']))
{
    $id = (int) $_GET['id'];

    $hapus = mysqli_query(
        $koneksi,
        "DELETE FROM supplier
        WHERE id_supplier = '$id'"
    );

    if($hapus)
    {
        echo "
        <script>
            alert('Data supplier berhasil dihapus');
            window.location='index.php';
        </script>
        ";
    }
    else
    {
        echo "
        <script>
            alert('Data supplier gagal dihapus');
            window.location='index.php';
        </script>
        ";
    }
}
else
{
    header("Location:index.php");
}