<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Dashboard Kasir</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        *{ margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
        body{ min-height:100vh; display:flex; justify-content:center; align-items:center; background:linear-gradient(135deg, #ffffff, #ffe4ec, #ffd6e7); }
        .login-wrapper{ width:950px; max-width:95%; display:flex; overflow:hidden; border-radius:25px; background:#fff; box-shadow:0 15px 40px rgba(0,0,0,.08); }
        .left-side{ width:45%; padding:50px; background:linear-gradient(135deg, #ff9fbc, #ff7aa8); color:white; display:flex; flex-direction:column; justify-content:center; }
        .left-side i{ font-size:70px; margin-bottom:20px; }
        .left-side h1{ font-size:34px; margin-bottom:10px; }
        .left-side p{ opacity:.9; line-height:1.7; }
        .right-side{ width:55%; padding:50px; }
        .login-title{ text-align:center; margin-bottom:30px; }
        .login-title h2{ color:#334155; }
        .login-title p{ color:#64748b; font-size:14px; }
        .form-group{ margin-bottom:18px; }
        .form-group label{ display:block; margin-bottom:8px; color:#475569; font-size:14px; }
        .input-box{ position:relative; }
        .input-box i{ position:absolute; left:15px; top:50%; transform:translateY(-50%); color:#94a3b8; }
        .input-box input{ width:100%; padding:14px 14px 14px 45px; border:1px solid #e2e8f0; border-radius:12px; outline:none; transition:.3s; }
        .input-box input:focus{ border-color:#ff7aa8; }
        .btn-login{ width:100%; border:none; padding:14px; border-radius:12px; background:#ff7aa8; color:white; font-size:15px; font-weight:600; cursor:pointer; transition:.3s; }
        .btn-login:hover{ background:#ff6297; }
        .demo-account{ margin-top:20px; padding:15px; border-radius:12px; background:#fff4f7; border:1px solid #ffd0df; color:#475569; font-size:14px; }
        .demo-account strong{ color:#e11d48; }
        .footer{ text-align:center; margin-top:20px; color:#94a3b8; font-size:13px; }
        @media(max-width:768px){ .login-wrapper{ flex-direction:column; } .left-side, .right-side{ width:100%; } }
    </style>
</head>
<body>
<div class="login-wrapper">
    <div class="left-side">
        <i class="fa-solid fa-cash-register"></i>
        <h1>Sistem Kasir</h1>
        <p>Kelola produk, transaksi, stok barang, dan laporan penjualan dalam satu dashboard.</p>
    </div>
    <div class="right-side">
        <div class="login-title">
            <h2>Login Dashboard</h2>
            <p>Masuk untuk melanjutkan</p>
        </div>
        <form action="proses_login.php" method="POST">
            <div class="form-group">
                <label>ID User</label>
                <div class="input-box">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="username" placeholder="Masukkan ID User" required>
                </div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <div class="input-box">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="Masukkan Password" required>
                </div>
            </div>
            <button type="submit" class="btn-login">
                <i class="fa-solid fa-right-to-bracket"></i> Login
            </button>
        </form>
        <div class="demo-account">
            <strong>Akun Login Demo</strong><br>
            ID : <b>login</b><br>
            Password : <b>login</b>
        </div>
        <div class="footer">Dashboard Kasir © 2026</div>
    </div>
</div>
</body>
</html>