<?php

require_once "../config/koneksi.php";

$error = "";

if(isset($_POST['simpan'])){

    $nama_supplier = mysqli_real_escape_string(
        $koneksi,
        $_POST['nama_supplier']
    );

    $simpan = mysqli_query(
        $koneksi,
        "INSERT INTO supplier
        (
            nama_supplier
        )
        VALUES
        (
            '$nama_supplier'
        )"
    );

    if($simpan){

        echo "
        <script>
        alert('Supplier berhasil ditambahkan');
        window.location='../dashboard/index.php';
        </script>
        ";

        exit;

    }else{

        $error = mysqli_error($koneksi);

    }

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Tambah Supplier</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    font-family:'Poppins',sans-serif;
}

/* Background soft pink gradient */
body{
    min-height:100vh;
    background: linear-gradient(135deg, #ffe4ec, #ffd6e7, #fff5f8);
}

/* Glass card */
.glass{
    background: rgba(255,255,255,.55);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(255, 182, 193, .4);
    border-radius:25px;
    box-shadow: 0 10px 40px rgba(255, 182, 193, .25);
}

/* Text */
label{
    color:#d63384;
    font-weight:500;
}

.title{
    color:#d63384;
    font-weight:700;
}

/* Input */
.form-control{
    border:none;
    border-radius:15px;
    padding:12px;
    background:#ffffff;
}

.form-control:focus{
    box-shadow:0 0 0 0.2rem rgba(255, 105, 180, 0.25);
}

/* Button Save */
.btn-save{
    background: linear-gradient(135deg, #ff8fb1, #f7a8c4);
    color:white;
    border:none;
    border-radius:15px;
    font-weight:600;
    padding:12px;
}

.btn-save:hover{
    background: linear-gradient(135deg, #ff6f9c, #f48fb1);
    color:white;
}

/* Button Back */
.btn-back{
    background: white;
    color:#d63384;
    border: 2px solid #ff8fb1;
    border-radius: 15px;
    padding: 10px 20px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: .3s;
    box-shadow: 0 5px 15px rgba(255, 182, 193, .2);
}

.btn-back:hover{
    background: #fff0f5;
    color:#d63384;
    border-color: #d63384;
    transform:translateY(-2px);
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

<div class="glass p-5">

<div class="text-center mb-4">
    <h2 class="title">🚚 Tambah Supplier</h2>
    <p class="text-muted">Tambahkan supplier baru</p>
</div>

<?php if($error != ""){ ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php } ?>

<form method="POST">
    <div class="mb-4">
        <label>Nama Supplier</label>
        <input type="text" name="nama_supplier" class="form-control" placeholder="Contoh : Unilever" required>
    </div>

    <button type="submit" name="simpan" class="btn btn-save w-100">
        <i class="fa-solid fa-floppy-disk"></i> Simpan Supplier
    </button>
</form>

</div>

</div>

</div>

</div>

</body>
</html>