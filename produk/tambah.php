<?php
require_once "../config/koneksi.php";

$error = "";

$dataKategori = mysqli_query($koneksi,"SELECT * FROM kategori ORDER BY id_kategori ASC");
$dataSupplier = mysqli_query($koneksi,"SELECT * FROM supplier ORDER BY id_supplier ASC");

if(isset($_POST['simpan'])){

    $nama = mysqli_real_escape_string($koneksi,$_POST['nama_barang']);
    $harga = mysqli_real_escape_string($koneksi,$_POST['harga']);
    $stok = mysqli_real_escape_string($koneksi,$_POST['stok']);
    $id_kategori = mysqli_real_escape_string($koneksi,$_POST['id_kategori']);
    $id_supplier = mysqli_real_escape_string($koneksi,$_POST['id_supplier']);

    // Cek apakah produk dengan nama yang sama persis sudah ada di database
    $cek_produk = mysqli_query($koneksi, "SELECT * FROM barang WHERE nama_barang = '$nama'");

    if (mysqli_num_rows($cek_produk) > 0) {
        // JIKA PRODUK SUDAH ADA: Lakukan proses UPDATE (Stok ditambah, Harga & Kategori & Supplier diperbarui)
        $sql = mysqli_query($koneksi, 
            "UPDATE barang 
             SET harga = '$harga', 
                 stok = stok + '$stok', 
                 id_kategori = '$id_kategori', 
                 id_supplier = '$id_supplier' 
             WHERE nama_barang = '$nama'"
        );
        $pesan_alert = "Produk sudah ada! Stok ditambahkan dan data diperbarui.";

    } else {
        // JIKA PRODUK BELUM ADA: Lakukan proses INSERT (Tambah data baru)
        $sql = mysqli_query($koneksi,
            "INSERT INTO barang (nama_barang, harga, stok, id_kategori, id_supplier)
             VALUES ('$nama', '$harga', '$stok', '$id_kategori', '$id_supplier')"
        );
        $pesan_alert = "Produk baru berhasil ditambahkan.";
    }

    // Eksekusi redirect jika query (UPDATE atau INSERT) berhasil
    if($sql){
        echo "<script>alert('$pesan_alert');window.location='index.php';</script>";
        exit;
    } else {
        $error = mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Tambah Produk</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
/* GLOBAL */
body{
    font-family:'Poppins',sans-serif;
    background: linear-gradient(135deg,#ffffff,#ffe4ec,#ffd6e7);
    min-height:100vh;
    color:#334155;
}

/* CARD */
.glass-card{
    background:#ffffff;
    border-radius:25px;
    padding:30px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

/* TITLE */
.title{
    color:#db2777;
    font-weight:700;
}

.subtitle{
    color:#64748b;
}

/* FORM */
.form-control,
.form-select{
    border:1px solid #fbcfe8;
    border-radius:12px;
    padding:12px;
}

.form-control:focus,
.form-select:focus{
    border-color:#ec4899;
    box-shadow:0 0 0 3px rgba(236,72,153,.15);
}

/* LABEL */
label{
    font-weight:600;
    color:#db2777;
}

/* BUTTON SAVE */
.btn-save{
    background:#ec4899;
    border:none;
    border-radius:12px;
    padding:12px;
    font-weight:600;
    color:white;
    transition:.2s;
}

.btn-save:hover{
    background:#db2777;
    transform:translateY(-2px);
}

/* BUTTON BACK */
.btn-back{
    background: white;
    color:#ec4899;
    border: 2px solid #fbcfe8;
    border-radius: 12px;
    padding: 10px 20px;
    font-weight: 600;
    transition: .3s;
    text-decoration: none;
    display: inline-block;
    box-shadow: 0 5px 15px rgba(236,72,153,.1);
}

.btn-back:hover{
    background: #fffafb;
    border-color: #ec4899;
    color:#db2777;
    transform:translateY(-2px);
}
</style>

</head>

<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="mb-4">
                <a href="../dashboard/index.php" class="btn-back">
                    <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Dashboard
                </a>
            </div>

            <div class="glass-card">
                
                <div class="text-center mb-4">
                    <h1 class="title">📦 Tambah Produk</h1>
                    <p class="subtitle">Input data produk dengan desain modern</p>
                </div>

                <?php if($error != ""){ ?>
                    <div class="alert alert-danger">
                        <?= $error ?>
                    </div>
                <?php } ?>

                <form method="POST">

                    <div class="mb-3">
                        <label>Nama Produk</label>
                        <input type="text" name="nama_barang" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Stok</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Kategori</label>
                        <select name="id_kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php while($k=mysqli_fetch_assoc($dataKategori)){ ?>
                                <option value="<?= $k['id_kategori']; ?>">
                                    <?= $k['nama_kategori']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label>Supplier</label>
                        <select name="id_supplier" class="form-select" required>
                            <option value="">-- Pilih Supplier --</option>
                            <?php while($s=mysqli_fetch_assoc($dataSupplier)){ ?>
                                <option value="<?= $s['id_supplier']; ?>">
                                    <?= $s['nama_supplier']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <button type="submit" name="simpan" class="btn btn-save w-100">
                        <i class="fa fa-save"></i> Simpan Produk
                    </button>

                </form>

            </div>
        </div>
    </div>
</div>

</body>
</html>