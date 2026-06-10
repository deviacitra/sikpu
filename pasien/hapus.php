<?php
session_start();
include '../config/koneksi.php';

// Validasi session
if (!isset($_SESSION['id_petugas'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Validasi ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

// Gunakan prepared statement untuk keamanan
$stmt = $koneksi->prepare("DELETE FROM pasien WHERE id = ?");

if ($stmt) {
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: index.php?success=deleted");
        exit();
    } else {
        header("Location: index.php?error=failed");
        exit();
    }
    
    $stmt->close();
} else {
    header("Location: index.php?error=failed");
    exit();
}

$koneksi->close();
?>
