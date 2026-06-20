<?php
require_once "../config/koneksi.php";

$data = mysqli_query(
    $koneksi,
    "SELECT * FROM supplier
     ORDER BY id_supplier DESC"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body { background: #fff5f8; }
        .card-custom { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(255, 182, 193, 0.25); background: #ffffff; }
        .card-header { background: linear-gradient(135deg, #ff8fb1, #f7a8c4) !important; color: white; border-top-left-radius: 20px !important; border-top-right-radius: 20px !important; }
        .table { vertical-align: middle; }
        .table thead { background: #ffe4ec; }
        .table-hover tbody tr:hover { background: #fff0f5; }
        .btn-light { background: #ffffff; border: none; color: #ff5c8a; font-weight: 500; }
        .btn-light:hover { background: #ffe4ec; color: #d63384; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="card card-custom">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">🚚 Data Supplier</h4>
            <a href="tambah.php" class="btn btn-light"><i class="fa-solid fa-plus"></i> Tambah Supplier</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="70" class="text-center">No</th>
                        <th>Nama Supplier</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while($row = mysqli_fetch_assoc($data)){
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['nama_supplier']); ?></td>
                        <td class="text-center">
                            <a href="edit.php?id=<?= $row['id_supplier']; ?>" class="btn btn-sm btn-warning text-white">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="hapus.php?id=<?= $row['id_supplier']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                <i class="fa-solid fa-trash"></i>
                            </a>
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