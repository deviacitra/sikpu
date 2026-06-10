<?php
session_start();
include '../config/koneksi.php';

// Validasi session
if (!isset($_SESSION['id_petugas'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Validasi input (Pastikan 'petugas' juga divalidasi)
if (empty($_POST['nama']) || empty($_POST['kelas']) || empty($_POST['keluhan']) || empty($_POST['pengobatan']) || empty($_POST['tanggal']) || empty($_POST['petugas'])) {
    header("Location: tambah.php?error=required");
    exit();
}

// Sanitasi input
$nama = htmlspecialchars($_POST['nama']);
$kelas = htmlspecialchars($_POST['kelas']);
$keluhan = htmlspecialchars($_POST['keluhan']);
$pengobatan = htmlspecialchars($_POST['pengobatan']);
$tanggal = $_POST['tanggal'];

// UBAH DI SINI: Ambil dari input manual form, bukan session otomatis
$petugas = htmlspecialchars($_POST['petugas']); 

// Gunakan prepared statement
$stmt = $koneksi->prepare("INSERT INTO pasien (nama, kelas, keluhan, pengobatan, tanggal, petugas) VALUES (?, ?, ?, ?, ?, ?)");

if ($stmt) {
    // Bind 6 parameter "s"
    $stmt->bind_param("ssssss", $nama, $kelas, $keluhan, $pengobatan, $tanggal, $petugas);
    
    if ($stmt->execute()) {
        header("Location: index.php?success=added");
        exit();
    } else {
        header("Location: tambah.php?error=failed");
        exit();
    }
    
    $stmt->close();
} else {
    header("Location: tambah.php?error=failed");
    exit();
}

$koneksi->close();
?>