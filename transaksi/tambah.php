<?php

require_once "../config/koneksi.php";

$produk = mysqli_query(
    $koneksi,
    "SELECT * FROM barang ORDER BY nama_barang ASC"
);

if(isset($_POST['simpan'])){

    $barang = $_POST['barang'];
    $qty    = $_POST['qty'];
    $bayar  = $_POST['bayar'];

    $grandTotal = 0;

    // 🌸 CEK STOK DAN HITUNG TOTAL
    foreach($barang as $i => $id_barang){

        $q = mysqli_fetch_assoc(
            mysqli_query(
                $koneksi,
                "SELECT nama_barang, harga, stok FROM barang WHERE id_barang='$id_barang'"
            )
        );

        // FITUR CEK STOK KURANG (VALIDASI SERVER)
        if($qty[$i] > $q['stok']) {
            echo "<script>
                alert('Transaksi Gagal! Stok untuk produk \"" . $q['nama_barang'] . "\" tidak mencukupi. (Sisa stok: " . $q['stok'] . ")');
                window.history.back(); 
            </script>";
            exit;
        }

        $subtotal = $q['harga'] * $qty[$i];
        $grandTotal += $subtotal;
    }

    $kembalian = $bayar - $grandTotal;

    // FITUR CEK UANG KURANG (Validasi Server Lapis 2 sebagai pelindung tambahan)
    if($bayar < $grandTotal){
        echo "<script>
            alert('Transaksi Gagal! Uang bayar (Rp " . number_format($bayar, 0, ',', '.') . ") kurang. Total belanja adalah Rp " . number_format($grandTotal, 0, ',', '.') . "');
            window.history.back(); 
        </script>";
        exit;
    }

    $simpan = mysqli_query(
        $koneksi,
        "INSERT INTO transaksi
        (
            tanggal,
            total_belanja,
            bayar,
            kembalian,
            id_user
        )
        VALUES
        (
            CURDATE(),
            '$grandTotal',
            '$bayar',
            '$kembalian',
            1
        )"
    );

    if(!$simpan){
        die("ERROR TRANSAKSI: " . mysqli_error($koneksi));
    }

    $id_transaksi = mysqli_insert_id($koneksi);

    foreach($barang as $i => $id_barang){

        $q = mysqli_fetch_assoc(
            mysqli_query(
                $koneksi,
                "SELECT harga FROM barang WHERE id_barang='$id_barang'"
            )
        );

        $subtotal = $q['harga'] * $qty[$i];

        // INSERT DETAIL TRANSAKSI
        mysqli_query(
            $koneksi,
            "INSERT INTO detail_transaksi
            (
                id_transaksi,
                id_barang,
                jumlah,
                subtotal
            )
            VALUES
            (
                '$id_transaksi',
                '$id_barang',
                '".$qty[$i]."',
                '$subtotal'
            )"
        );

        // UPDATE STOK BARANG
        mysqli_query(
            $koneksi,
            "UPDATE barang
            SET stok = stok - ".$qty[$i]."
            WHERE id_barang='$id_barang'"
        );
    }

    // REDIRECT KE FOLDER DASHBOARD
    echo "<script>
        alert('Transaksi berhasil disimpan! Kembalian: Rp " . number_format($kembalian, 0, ',', '.') . "');
        window.location='../dashboard/index.php';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<title>Transaksi Kasir</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

/* 🌸 GLOBAL STYLE */
*{
    font-family:'Poppins',sans-serif;
}

/* 🌸 BACKGROUND SOFT PINK */
body{
    background: linear-gradient(
        135deg,
        #fff5f8 0%,
        #ffe4ec 40%,
        #fce7f3 70%,
        #ffffff 100%
    );
    min-height:100vh;
}

/* 💎 CARD GLASS */
.card-kasir{
    background: rgba(255,255,255,.65);
    backdrop-filter: blur(18px);
    border-radius:30px;
    padding:30px;
    border:1px solid rgba(255, 182, 193, .35);
    box-shadow: 0 10px 35px rgba(255, 182, 193, .25);
}

/* TITLE */
.title{
    color:#d63384;
    font-weight:700;
}

/* TABLE */
.table{
    background:white;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(255, 182, 193, .15);
}

.table thead{
    background: linear-gradient(135deg, #ff8fb1, #f7a8c4);
    color:white;
}

.table tbody tr:hover{
    background:#fff0f5;
}

/* INPUT */
.form-control,
.form-select{
    border-radius:12px;
    border:1px solid #ffd6e7;
}

.form-control:focus,
.form-select:focus{
    box-shadow:0 0 0 0.2rem rgba(255, 105, 180, 0.25);
    border-color:#ff8fb1;
}

/* ADD BUTTON */
.btn-add{
    background: linear-gradient(135deg, #f472b6, #ec4899);
    color:white;
    border:none;
    border-radius:12px;
    font-weight:600;
    padding:10px 15px;
}

.btn-add:hover{
    background: linear-gradient(135deg, #ff6f9c, #f472b6);
    color:white;
}

/* DELETE BUTTON */
.btn-delete{
    background: linear-gradient(135deg, #fb7185, #ef4444);
    color:white;
    border:none;
    border-radius:10px;
}

.btn-delete:hover{
    opacity:0.9;
    color:white;
}

/* SAVE BUTTON */
.btn-warning{
    background: linear-gradient(135deg, #ff8fb1, #f7a8c4);
    border:none;
    color:white;
    font-weight:600;
    border-radius:15px;
    padding:12px 25px;
}

.btn-warning:hover{
    background: linear-gradient(135deg, #ff6f9c, #f472b6);
    color:white;
}

/* BUTTON BACK TO DASHBOARD */
.btn-back{
    background: white;
    color:#d63384;
    border: 2px solid #ff8fb1;
    border-radius: 12px;
    padding: 10px 20px;
    font-weight: 600;
    transition: .3s;
    text-decoration: none;
    display: inline-block;
    box-shadow: 0 5px 15px rgba(255, 182, 193, .15);
}

.btn-back:hover{
    background: #fff0f5;
    border-color: #d63384;
    color:#d63384;
    transform:translateY(-2px);
}

label{
    color:#d63384;
    font-weight:500;
}

/* BOX TOTAL BELANJA */
.box-total {
    background: rgba(255, 143, 177, 0.15);
    border: 2px dashed #ff8fb1;
    border-radius: 15px;
    padding: 15px;
}

</style>

</head>

<body>

<div class="container py-5">

<div class="mb-4">
    <a href="../dashboard/index.php" class="btn-back">
        <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Dashboard
    </a>
</div>

<div class="card-kasir">

<h2 class="title mb-4">🛒 Transaksi Kasir</h2>

<form method="POST" onsubmit="return validasiPembayaran()">

<table class="table" id="produkTable">

<thead>
<tr>
<th>Produk</th>
<th width="150">Qty</th>
<th width="80">Aksi</th>
</tr>
</thead>

<tbody>

<tr>

<td>
<select name="barang[]" class="form-select select-produk" onchange="resetQty(this)" required>
<option value="" data-harga="0" data-stok="0">Pilih Produk</option>

<?php 
// Me-reset pointer agar bisa dibaca berkali-kali oleh JS jika tambah baris
mysqli_data_seek($produk, 0);
while($p=mysqli_fetch_assoc($produk)){ 
?>
<option value="<?= $p['id_barang']; ?>" data-harga="<?= $p['harga']; ?>" data-stok="<?= $p['stok']; ?>">
<?= $p['nama_barang']; ?> - Rp <?= number_format($p['harga'], 0, ',', '.'); ?> (Stok: <?= $p['stok']; ?>)
</option>
<?php } ?>

</select>
</td>

<td>
<input type="number" name="qty[]" class="form-control input-qty" min="1" oninput="cekStok(this)" required>
</td>

<td>
<button type="button" class="btn btn-delete" onclick="hapusBaris(this)">
<i class="fa fa-trash"></i>
</button>
</td>

</tr>

</tbody>

</table>

<button type="button" class="btn btn-add mb-4" onclick="tambahBaris()">
<i class="fa fa-plus"></i> Tambah Produk
</button>

<div class="row">
    <div class="col-md-6 ms-auto">
        
        <div class="box-total mb-3 text-end">
            <h4 class="title mb-0">Total Belanja: Rp <span id="tampilTotal">0</span></h4>
        </div>

        <div class="mb-4">
            <label>Uang Bayar</label>
            <input type="number" id="bayarInput" name="bayar" class="form-control form-control-lg" min="0" placeholder="Rp 0" required>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" name="simpan" class="btn btn-warning btn-lg w-100">
                💾 Simpan Transaksi
            </button>
        </div>

    </div>
</div>

</form>

</div>

</div>

<script>

function tambahBaris(){
    let table = document.querySelector("#produkTable tbody");
    let row = table.rows[0].cloneNode(true);

    // Reset nilai pilihan dan qty saat ditambah
    row.querySelector("select").selectedIndex = 0;
    row.querySelector("input").value = "";

    table.appendChild(row);
    
    // Panggil ulang perhitungan total
    hitungTotal();
}

function hapusBaris(btn){
    let row = btn.parentNode.parentNode;
    let table = document.querySelector("#produkTable tbody");

    if(table.rows.length > 1){
        row.remove();
        // Panggil ulang perhitungan total setelah baris dihapus
        hitungTotal(); 
    } else {
        alert("Minimal harus ada 1 baris produk!");
    }
}

// 🌸 FUNGSI RESET QTY SAAT PRODUK DIGANTI
function resetQty(selectElem) {
    let row = selectElem.closest('tr');
    let inputQty = row.querySelector('.input-qty');
    inputQty.value = ""; // Kosongkan input qty
    hitungTotal();
}

// 🌸 FUNGSI VALIDASI STOK REAL-TIME
function cekStok(inputElem) {
    let row = inputElem.closest('tr');
    let select = row.querySelector('.select-produk');
    
    // Jika belum pilih produk tapi sudah isi qty
    if (select.selectedIndex === 0) {
        alert("Pilih produk terlebih dahulu!");
        inputElem.value = "";
        return;
    }

    let maxStok = parseInt(select.options[select.selectedIndex].getAttribute("data-stok")) || 0;
    let qty = parseInt(inputElem.value) || 0;

    if (qty > maxStok) {
        alert("Peringatan: Stok tidak mencukupi! Sisa stok hanya " + maxStok);
        inputElem.value = maxStok; // Otomatis kembalikan ke maksimal stok
    }

    hitungTotal();
}

// FUNGSI HITUNG TOTAL REAL-TIME
function hitungTotal() {
    let grandTotal = 0;
    let rows = document.querySelectorAll("#produkTable tbody tr");

    // Loop semua baris di tabel
    rows.forEach(function(row) {
        let select = row.querySelector(".select-produk");
        let inputQty = row.querySelector(".input-qty");

        let harga = 0;
        let qty = parseFloat(inputQty.value) || 0;

        // Ambil harga dari atribut data-harga option yang sedang dipilih
        if (select.selectedIndex > 0) {
            harga = parseFloat(select.options[select.selectedIndex].getAttribute("data-harga")) || 0;
        }

        grandTotal += (harga * qty);
    });

    // Format angka ke format Rupiah (Ribuan)
    let formatRupiah = new Intl.NumberFormat('id-ID').format(grandTotal);
    
    // Tampilkan ke layar
    document.getElementById("tampilTotal").innerText = formatRupiah;
    
    // Kembalikan nilai angka aslinya agar bisa dipakai oleh fungsi validasiPembayaran()
    return grandTotal;
}

// 🌸 LAPIS 1: CEK UANG BAYAR TANPA REFRESH HALAMAN
function validasiPembayaran() {
    let grandTotal = hitungTotal(); // Ambil total belanja secara langsung
    let bayar = parseFloat(document.getElementById("bayarInput").value) || 0;

    if (bayar < grandTotal) {
        // Hitung selisih kekurangannya
        let kurang = grandTotal - bayar;
        let formatKurang = new Intl.NumberFormat('id-ID').format(kurang);
        
        // Tampilkan peringatan
        alert("Transaksi Gagal! \nUang bayar kurang Rp " + formatKurang);
        
        // MENCEGAH FORM DIKIRIM (HALAMAN TIDAK AKAN REFRESH)
        return false; 
    }

    // Jika uang cukup, izinkan form dikirim ke PHP
    return true; 
}

</script>

</body>
</html>