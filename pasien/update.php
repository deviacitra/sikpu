<?php
include '../config/koneksi.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// cek login
if (!isset($_SESSION['id_petugas'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../layout/sidebar.php';

// Validasi input
if (empty($_POST['id']) || empty($_POST['nama']) || empty($_POST['kelas']) || empty($_POST['keluhan']) || empty($_POST['pengobatan']) || empty($_POST['tanggal'])) {
    header("Location: index.php?error=required");
    exit();
}

// Sanitasi input
$id = intval($_POST['id']);
$nama = htmlspecialchars($_POST['nama']);
$kelas = htmlspecialchars($_POST['kelas']);
$keluhan = htmlspecialchars($_POST['keluhan']);
$pengobatan = htmlspecialchars($_POST['pengobatan']);
$tanggal = $_POST['tanggal'];

// Gunakan prepared statement
$stmt = $koneksi->prepare("UPDATE pasien SET nama = ?, kelas = ?, keluhan = ?, pengobatan = ?, tanggal = ? WHERE id = ?");

if ($stmt) {
    $stmt->bind_param("sssssi", $nama, $kelas, $keluhan, $pengobatan, $tanggal, $id);
    
    if ($stmt->execute()) {
        header("Location: index.php?success=updated");
        exit();
    } else {
        header("Location: edit.php?id=$id&error=failed");
        exit();
    }
    
    $stmt->close();
} else {
    header("Location: edit.php?id=$id&error=failed");
    exit();
}

$query = "UPDATE pasien SET 
    nama='$nama',
    kelas='$kelas',
    keluhan='$keluhan',
    pengobatan='$pengobatan',
    tanggal='$tanggal'
    WHERE id='$id'";

$koneksi->query($query);

$koneksi->close();

header("Location: index.php");
exit;
?>
