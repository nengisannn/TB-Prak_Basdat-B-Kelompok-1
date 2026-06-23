<?php

require_once "../config/koneksi.php";

if(isset($_POST['simpan'])){

    $nama_kategori = mysqli_real_escape_string(
        $koneksi,
        $_POST['nama_kategori']
    );

    // 1. Cek apakah nama kategori sudah ada di database
    $cek_kategori = mysqli_query($koneksi, "SELECT * FROM kategori WHERE nama_kategori = '$nama_kategori'");

    if(mysqli_num_rows($cek_kategori) > 0){
        
        // JIKA SUDAH ADA: Munculkan peringatan dan hentikan proses simpan
        echo "
        <script>
            alert('Gagal! Kategori dengan nama \"$nama_kategori\" sudah terdaftar.');
            window.location='index.php'; 
        </script>
        ";
        exit;

    } else {

        // JIKA BELUM ADA: Lakukan proses INSERT
        $query = mysqli_query(
            $koneksi,
            "INSERT INTO kategori
            (
                nama_kategori
            )
            VALUES
            (
                '$nama_kategori'
            )"
        );

        if($query){

            echo "
            <script>
                alert('Kategori berhasil ditambahkan');
                window.location='index.php'; 
            </script>
            ";
            exit;

        }else{

            echo "
            <script>
                alert('Gagal menambahkan kategori');
            </script>
            ";

        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Tambah Kategori</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<style>

*{
    font-family:'Poppins',sans-serif;
}

body{

    min-height:100vh;

    background:
    linear-gradient(
        135deg,
        #fffafb,
        #ffe4ec,
        #ffd6e7
    );

}

/* CARD */

.card-custom{

    background:white;

    border:none;

    border-radius:30px;

    overflow:hidden;

    box-shadow:
    0 15px 35px rgba(236,72,153,.15);

}

/* HEADER */

.header-custom{

    background:
    linear-gradient(
        135deg,
        #ec4899,
        #f472b6
    );

    color:white;

    text-align:center;

    padding:30px;

}

.header-custom h2{

    font-weight:700;

    margin:0;
}

/* FORM */

.form-control{

    border:2px solid #fbcfe8;

    border-radius:15px;

    padding:13px;

}

.form-control:focus{

    border-color:#ec4899;

    box-shadow:
    0 0 0 4px rgba(236,72,153,.15);

}

/* LABEL */

label{

    color:#be185d;

    font-weight:600;

    margin-bottom:8px;

}

/* BUTTON SAVE */

.btn-save{

    width:100%;

    background:
    linear-gradient(
        135deg,
        #ec4899,
        #f472b6
    );

    color:white;

    border:none;

    border-radius:15px;

    padding:14px;

    font-weight:600;

    transition:.3s;

}

.btn-save:hover{

    background:
    linear-gradient(
        135deg,
        #db2777,
        #ec4899
    );

    transform:translateY(-2px);

    color:white;
}

/* BUTTON BACK */

.btn-back{
    background: white;
    color:#ec4899;
    border: 2px solid #fbcfe8;
    border-radius: 15px;
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

.icon{

    font-size:70px;

    margin-bottom:10px;
}

</style>

</head>

<body>

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-lg-6">

<div class="mb-4">
    <a href="../dashboard/index.php" class="btn-back">
        <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Dashboard
    </a>
</div>

<div class="card-custom">

<div class="header-custom">

<div class="icon">
🌸
</div>

<h2>
Tambah Kategori
</h2>

<p class="mb-0">
Tambahkan kategori produk baru
</p>

</div>

<div class="p-4">

<form method="POST">

<div class="mb-4">

<label>
Nama Kategori
</label>

<input
type="text"
name="nama_kategori"
class="form-control"
placeholder="Masukkan nama kategori"
required>

</div>

<button
type="submit"
name="simpan"
class="btn btn-save">

<i class="fa-solid fa-floppy-disk"></i>

Simpan Kategori

</button>

</form>

</div>

</div>

</div>

</div>

</div>

</body>
</html>