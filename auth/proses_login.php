<?php
session_start();
include '../config/koneksi.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// 1. Validasi input kosong
if (empty($username) || empty($password)) {
    header("Location: login.php?error=required");
    exit();
}

// 2. Gunakan Prepared Statements untuk keamanan (mencegah SQL Injection)
$stmt = mysqli_prepare($koneksi, "SELECT * FROM petugas WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if ($data) {
    // 3. PERBAIKAN UTAMA: Gunakan password_verify untuk mengecek hash
    if (password_verify($password, $data['password'])) {

        // Simpan session
        $_SESSION['id_petugas'] = $data['id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['nama_petugas'] = $data['nama_petugas'];

        // Redirect ke dashboard
        header("Location: ../dashboard/index.php");
        exit();

    } else {
        // Password salah
        header("Location: login.php?error=invalid");
        exit();
    }
} else {
    // Username tidak ditemukan
    header("Location: login.php?error=invalid");
    exit();
}
?>