<?php

require_once "../config/koneksi.php";

if(!isset($_GET['id']))
{
    header("Location:index.php");
    exit;
}

$id = (int)$_GET['id'];

$data = mysqli_query(
    $koneksi,
    "SELECT * FROM supplier
     WHERE id_supplier='$id'"
);

$supplier = mysqli_fetch_assoc($data);

if(!$supplier)
{
    echo "Data supplier tidak ditemukan";
    exit;
}

if(isset($_POST['simpan']))
{
    $nama_supplier = mysqli_real_escape_string(
        $koneksi,
        $_POST['nama_supplier']
    );

    $update = mysqli_query(
        $koneksi,
        "UPDATE supplier
         SET nama_supplier='$nama_supplier'
         WHERE id_supplier='$id'"
    );

    if($update)
    {
        echo "
        <script>
            alert('Supplier berhasil diubah');
            window.location='index.php';
        </script>
        ";
    }
    else
    {
        echo "
        <script>
            alert('Supplier gagal diubah');
        </script>
        ";
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Edit Supplier</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
rel="stylesheet">

<style>

*{
    font-family:'Poppins',sans-serif;
}

body{
    background:linear-gradient(
        135deg,
        #ffffff 0%,
        #fff8fb 50%,
        #ffe4f1 100%
    );
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

/* CARD */
.card-custom{
    width:520px;
    border:none;
    border-radius:25px;
    overflow:hidden;
    background:white;
    box-shadow:0 15px 40px rgba(255,105,180,.15);
}

/* HEADER */
.card-header{
    background:linear-gradient(
        135deg,
        #ff8fb1,
        #ffb6c1
    );
    color:white;
    padding:20px;
}

.card-header h4{
    font-weight:600;
}

/* BODY */
.card-body{
    padding:30px;
}

/* LABEL */
.form-label{
    font-weight:500;
    color:#d63384;
}

/* INPUT */
.form-control{
    border:2px solid #ffd6e7;
    border-radius:12px;
    padding:12px;
}

.form-control:focus{
    border-color:#ff8fb1;
    box-shadow:0 0 12px rgba(255,143,177,.25);
}

/* BUTTON SAVE */
.btn-save{
    background:linear-gradient(
        135deg,
        #ff6fa5,
        #ff9ec7
    );
    border:none;
    color:white;
    border-radius:12px;
    padding:10px 25px;
    font-weight:500;
}

.btn-save:hover{
    color:white;
    transform:translateY(-2px);
    opacity:.95;
}

/* BUTTON BACK */
.btn-back{
    border-radius:12px;
    padding:10px 25px;
    font-weight:500;
}

/* ANIMATION */
.card-custom{
    animation:fadeIn .4s ease;
}

@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(20px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

</style>

</head>

<body>

<div class="card card-custom">

    <div class="card-header">

        <h4 class="mb-0">
            ✏️ Edit Supplier
        </h4>

    </div>

    <div class="card-body">

        <form method="POST">

            <div class="mb-4">

                <label class="form-label">
                    Nama Supplier
                </label>

                <input
                    type="text"
                    name="nama_supplier"
                    class="form-control"
                    required
                    value="<?= htmlspecialchars($supplier['nama_supplier']); ?>">

            </div>

            <div class="d-flex justify-content-between">

                <a href="index.php"
                class="btn btn-secondary btn-back">

                    <i class="fa fa-arrow-left"></i>
                    Kembali

                </a>

                <button
                    type="submit"
                    name="simpan"
                    class="btn btn-save">

                    <i class="fa fa-save"></i>
                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>