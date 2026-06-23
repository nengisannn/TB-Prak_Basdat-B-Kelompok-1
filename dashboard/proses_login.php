<?php
session_start();
// Menghubungkan ke file koneksi database kamu
include "../config/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Cek ke tabel admin
    $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        
        // Menyimpan data login ke session
        $_SESSION['login'] = true;
        $_SESSION['id_admin'] = $data['id_admin'];
        $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
        
        // JIKA BERHASIL: Langsung dialihkan ke index.php (Dashboard) menggunakan PHP Header
        header("Location: index.php");
        exit(); // Sangat penting untuk menambahkan exit() setelah header redirect
        
    } else {
        // JIKA GAGAL: Boleh tetap pakai alert agar user tahu kenapa gagal
        echo "<script>
                alert('Login Gagal! ID User atau Password salah.'); 
                window.location='login.php';
              </script>";
    }
}
?>