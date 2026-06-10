<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// redirect kalau sudah login
if (isset($_SESSION['id_petugas'])) {
    header("Location: ../dashboard/index.php");
    exit();
}

$error = '';
if (isset($_GET['error'])) {
    if ($_GET['error'] == 'invalid') {
        $error = 'Username atau password salah!';
    } elseif ($_GET['error'] == 'required') {
        $error = 'Harap isi semua field!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - SIKPU</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
body {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    /* Gradasi dibuat sedikit lebih soft */
    background: linear-gradient(135deg, #1e3c72, #2a5298, #00c6ff);
    font-family: 'Segoe UI', Roboto, sans-serif;
    margin: 0;
}

.login-box {
    width: 100%;
    max-width: 400px;
    padding: 40px 30px;
    border-radius: 20px;
    /* Ganti background ke putih bersih agar kontras dengan gradient body */
    background: rgba(255, 255, 255, 0.95);
    /* Shadow lebih dalam agar terlihat 'floating' */
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    animation: fadeIn 0.6s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(30px);}
    to { opacity: 1; transform: translateY(0);}
}

.title {
    text-align: center;
    margin-bottom: 30px;
}

.title h3 {
    font-weight: 800;
    color: #1e3c72;
    letter-spacing: -0.5px;
    margin-bottom: 5px;
}

.input-group-text {
    background: #f8f9fa;
    border-right: none;
    color: #1e3c72;
}

.form-control {
    border-radius: 8px;
    padding: 12px;
    border-left: none;
}

/* Efek saat input diklik */
.form-control:focus {
    box-shadow: none;
    border-color: #ced4da;
}

.input-group:focus-within .input-group-text {
    border-color: #2633e4;
    color: #2633e4;
    transition: 0.3s;
}

.input-group:focus-within .form-control {
    border-color: #2633e4;
    transition: 0.3s;
}

.btn-login {
    border-radius: 8px;
    padding: 12px;
    background: #2633e4;
    border: none;
    font-weight: 600;
    margin-top: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(38, 51, 228, 0.3);
}

.btn-login:hover {
    background: #1a24a5;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(38, 51, 228, 0.4);
}

.btn-login:active {
    transform: translateY(0);
}
</style>
</head>

<body>

<div class="login-box">
    <div class="title">
        <h3>SIKPU</h3>
        <small class="text-muted text-uppercase" style="letter-spacing: 1px;">Sistem Informasi UKS</small>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger py-2" style="font-size: 0.9rem;">
            <i class="fas fa-exclamation-circle me-2"></i><?= $error ?>
        </div>
    <?php endif; ?>

    <form action="proses_login.php" method="POST">
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>

        <div class="input-group mb-4">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>

        <button type="submit" class="btn btn-login w-100 text-white">
            MASUK <i class="fas fa-sign-in-alt ms-2"></i>
        </button>
    </form>
</div>

</body>
</html>