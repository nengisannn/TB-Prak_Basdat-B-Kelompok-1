<?php
// 1. MULAI SESSION DAN CEK LOGIN
session_start();

// Jika belum login, tendang kembali ke halaman login.php
if (!isset($_SESSION['login'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!'); 
            window.location='login.php';
          </script>";
    exit;
}

// 2. KONEKSI DATABASE
include "../config/koneksi.php";

// 3. QUERY DATA DASHBOARD
$totalProduk = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) total FROM barang"));
$totalStok = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(stok) total FROM barang"));
$totalTransaksi = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) total FROM transaksi"));
$totalPendapatan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(total_belanja) total FROM transaksi"));

$mingguan = [];
for($i = 1; $i <= 4; $i++) {
    $query = mysqli_query($koneksi, "SELECT SUM(total_belanja) as total FROM transaksi WHERE MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE()) AND CEIL(DAY(tanggal) / 7) = $i");
    $data = mysqli_fetch_assoc($query);
    $mingguan[] = $data['total'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body{ font-family:'Poppins',sans-serif; background: linear-gradient(135deg,#ffffff,#ffe4ec,#ffd6e7); color:#334155; }
        .sidebar{ position:fixed; width:260px; height:100vh; background: rgba(255,255,255,.9); backdrop-filter: blur(20px); padding:25px; border-right:1px solid #fbcfe8; }
        .logo{ font-size:22px; font-weight:700; color:#db2777; margin-bottom:25px; }
        .menu a{ display:flex; align-items:center; gap:10px; padding:12px; margin-bottom:8px; border-radius:12px; text-decoration:none; color:#64748b; font-weight:500; transition:.2s; }
        .menu a:hover{ background:#ffe4ec; color:#db2777; }
        .menu .logout { margin-top: 30px; color: #e11d48; background: #fff1f2; }
        .menu .logout:hover { background: #ffe4e6; color: #be123c; }
        .main{ margin-left:260px; padding:30px; }
        h2{ color:#db2777; font-weight:700; }
        .user-greeting { font-size: 16px; color: #64748b; margin-bottom: 20px; }
        .card-stat{ border:none; border-radius:18px; padding:15px; color:white; position:relative; box-shadow:0 10px 25px rgba(0,0,0,.08); transition:.2s; }
        .bg1{background:linear-gradient(135deg,#f472b6,#ec4899);}
        .bg2{background:linear-gradient(135deg,#f9a8d4,#f472b6);}
        .bg3{background:linear-gradient(135deg,#fbcfe8,#f9a8d4);}
        .bg4{background:linear-gradient(135deg,#fda4af,#fb7185);}
        .card-icon{ position:absolute; right:15px; top:15px; font-size:45px; opacity:.25; }
        .card{ border:none; border-radius:16px; background:#ffffff; box-shadow:0 10px 25px rgba(0,0,0,.05); }
    </style>
</head>
<body>
<div class="sidebar">
    <div class="logo"><i class="fa-solid fa-cart-shopping"></i> Kasir Pink</div>
    <div class="menu">
        <a href="#">📊 Dashboard</a>
        <a href="../produk">📦 Produk</a>
        <a href="../kategori">🏷 Kategori</a>
        <a href="../supplier">🚚 Supplier</a>
        <a href="../transaksi">🧾 Transaksi</a>
        <a href="../laporan">📄 Laporan</a>
        
        <a href="logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Keluar / Logout</a>
    </div>
</div>
<div class="main">
    <h2>Dashboard</h2>
    <div class="user-greeting">
        Halo, <b><?= $_SESSION['nama_lengkap'] ?? 'Admin'; ?></b>! Selamat datang kembali.
    </div>

    <div class="row mt-4">
        <div class="col-md-3"><div class="card-stat bg1"><i class="fa fa-box card-icon"></i><h6>Total Produk</h6><h3><?= $totalProduk['total'] ?? 0; ?></h3></div></div>
        <div class="col-md-3"><div class="card-stat bg2"><i class="fa fa-warehouse card-icon"></i><h6>Total Stok</h6><h3><?= $totalStok['total'] ?? 0; ?></h3></div></div>
        <div class="col-md-3"><div class="card-stat bg3"><i class="fa fa-receipt card-icon"></i><h6>Transaksi</h6><h3><?= $totalTransaksi['total'] ?? 0; ?></h3></div></div>
        <div class="col-md-3"><div class="card-stat bg4"><i class="fa fa-money-bill card-icon"></i><h6>Pendapatan</h6><h3>Rp <?= number_format($totalPendapatan['total'] ?? 0, 0, ',', '.'); ?></h3></div></div>
    </div>
    <div class="card p-4 mt-3">
        <h5>📈 Pendapatan per Minggu</h5>
        <canvas id="chart"></canvas>
    </div>
</div>
<script>
const ctx = document.getElementById('chart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: <?php echo json_encode($mingguan); ?>,
            borderColor: '#ec4899',
            backgroundColor: 'rgba(236, 72, 153, 0.2)',
            fill: true,
            tension: 0.4,
            borderWidth: 3
        }]
    },
    options: {
        scales: { y: { beginAtZero: true, ticks: { callback: function(v) { return 'Rp ' + v.toLocaleString('id-ID'); } } } }
    }
});
</script>
</body>
</html>