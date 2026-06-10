<?php
// File index.php - Entry point aplikasi
// Redirect ke login atau dashboard tergantung session

session_start();

if (isset($_SESSION['id_petugas'])) {
    // Jika sudah login, redirect ke dashboard
    header("Location: dashboard/index.php");
    exit();
} else {
    // Jika belum login, redirect ke halaman login
    header("Location: auth/login.php");
    exit();
}
?>
