<?php

require_once "../config/koneksi.php";

/*
|--------------------------------------------------------------------------
| Ambil Data Transaksi
|--------------------------------------------------------------------------
*/

$data = mysqli_query(
    $koneksi,
    "SELECT *
     FROM transaksi
     ORDER BY id_transaksi DESC"
);

if(!$data){
    die("Query Error : ".mysqli_error($koneksi));
}

/*
|--------------------------------------------------------------------------
| Statistik
|--------------------------------------------------------------------------
*/

$totalTransaksi = mysqli_fetch_assoc(
    mysqli_query(
        $koneksi,
        "SELECT COUNT(*) AS total
         FROM transaksi"
    )
);

$totalPendapatan = mysqli_fetch_assoc(
    mysqli_query(
        $koneksi,
        "SELECT COALESCE(
            SUM(total_belanja),
            0
         ) AS total
         FROM transaksi"
    )
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Data Transaksi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<style>

*{
    font-family:'Poppins',sans-serif;
}

body{
    background:linear-gradient(
        135deg,
        #fff5f7,
        #ffe4ec,
        #ffffff
    );
    min-height:100vh;
}

/* HEADER */

.page-title{
    color:#db2777;
    font-weight:700;
}

/* CARD STAT */

.card-stat{
    border:none;
    border-radius:25px;
    padding:25px;
    color:white;
    box-shadow:0 10px 25px rgba(236,72,153,.2);
}

.bg-pink{
    background:linear-gradient(
        135deg,
        #ec4899,
        #f472b6
    );
}

.bg-soft{
    background:linear-gradient(
        135deg,
        #fb7185,
        #f9a8d4
    );
}

/* GLASS */

.glass{
    background:rgba(255,255,255,.75);
    backdrop-filter:blur(20px);
    border-radius:25px;
    padding:25px;
    box-shadow:0 10px 30px rgba(236,72,153,.15);
}

/* TABLE */

.table{
    background:white;
    border-radius:15px;
    overflow:hidden;
}

.table thead{
    background:linear-gradient(
        135deg,
        #ec4899,
        #f472b6
    );
    color:white;
}

.table tbody tr:hover{
    background:#fff1f5;
}

/* BUTTON */

.btn-transaksi{
    background:linear-gradient(
        135deg,
        #ec4899,
        #f472b6
    );
    color:white;
    border:none;
    border-radius:12px;
    padding:12px 20px;
    font-weight:600;
}

.btn-transaksi:hover{
    color:white;
    opacity:.9;
}

/* STATUS */

.badge-pending{
    background:#f59e0b;
    color:white;
    padding:8px 14px;
    border-radius:10px;
}

.badge-selesai{
    background:#10b981;
    color:white;
    padding:8px 14px;
    border-radius:10px;
}

.badge-batal{
    background:#ef4444;
    color:white;
    padding:8px 14px;
    border-radius:10px;
}

/* ACTION BUTTON */

.btn-action{
    border-radius:10px;
}

</style>

</head>

<body>

<div class="container py-5">

<!-- HEADER -->

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="page-title">
        🧾 Data Transaksi
    </h2>

    <a href="tambah.php"
    class="btn btn-transaksi">

        <i class="fa-solid fa-cart-shopping"></i>

        Tambah Transaksi

    </a>

</div>

<!-- STATISTIK -->

<div class="row mb-4">

    <div class="col-md-6 mb-3">

        <div class="card-stat bg-pink">

            <h6>Total Transaksi</h6>

            <h2>
                <?= $totalTransaksi['total']; ?>
            </h2>

        </div>

    </div>

    <div class="col-md-6 mb-3">

        <div class="card-stat bg-soft">

            <h6>Total Pendapatan</h6>

            <h2>
                Rp <?= number_format(
                    $totalPendapatan['total'],
                    0,
                    ',',
                    '.'
                ); ?>
            </h2>

        </div>

    </div>

</div>

<!-- TABEL -->

<div class="glass">

    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Total Belanja</th>
                    <th>Bayar</th>
                    <th>Kembalian</th>
                    <th>Status</th>
                    <th width="220">Aksi</th>

                </tr>

            </thead>

            <tbody>

            <?php while($row = mysqli_fetch_assoc($data)){ ?>

                <tr>

                    <td>
                        #TRX<?= $row['id_transaksi']; ?>
                    </td>

                    <td>

                    <?php

                    if(!empty($row['tanggal'])){

                        echo date(
                            'd M Y',
                            strtotime($row['tanggal'])
                        );

                    }else{

                        echo "-";

                    }

                    ?>

                    </td>

                    <td>

                        <b>

                        Rp <?= number_format(
                            $row['total_belanja'],
                            0,
                            ',',
                            '.'
                        ); ?>

                        </b>

                    </td>

                    <td>

                        Rp <?= number_format(
                            $row['bayar'],
                            0,
                            ',',
                            '.'
                        ); ?>

                    </td>

                    <td>

                        Rp <?= number_format(
                            $row['kembalian'],
                            0,
                            ',',
                            '.'
                        ); ?>

                    </td>

                    <td>

                    <?php

                    if(isset($row['status'])){

                        if($row['status']=="Pending"){

                            echo "<span class='badge-pending'>Pending</span>";

                        }elseif($row['status']=="Selesai"){

                            echo "<span class='badge-selesai'>Selesai</span>";

                        }elseif($row['status']=="Batal"){

                            echo "<span class='badge-batal'>Batal</span>";

                        }else{

                            echo "<span class='badge bg-secondary'>-</span>";

                        }

                    }else{

                        echo "<span class='badge-selesai'>Selesai</span>";

                    }

                    ?>

                    </td>

                    <td>

                        <a
                        href="detail.php?id=<?= $row['id_transaksi']; ?>"
                        class="btn btn-info btn-sm btn-action">

                            <i class="fa fa-eye"></i>

                        </a>

                        <a
                        href="cetak.php?id=<?= $row['id_transaksi']; ?>"
                        target="_blank"
                        class="btn btn-secondary btn-sm btn-action">

                            <i class="fa fa-print"></i>

                        </a>

                        <a
                        href="status.php?id=<?= $row['id_transaksi']; ?>&status=Selesai"
                        class="btn btn-success btn-sm btn-action">

                            <i class="fa fa-check"></i>

                        </a>

                        <a
                        href="status.php?id=<?= $row['id_transaksi']; ?>&status=Batal"
                        class="btn btn-danger btn-sm btn-action">

                            <i class="fa fa-times"></i>

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