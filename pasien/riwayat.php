<?php
define('BASE_URL', '../');
include '../config/koneksi.php';
session_start();

$nama = $_GET['nama'] ?? '';

// Ambil data riwayat berdasarkan nama
$stmt = $koneksi->prepare("SELECT * FROM pasien WHERE nama = ? ORDER BY tanggal DESC");
$stmt->bind_param("s", $nama);
$stmt->execute();
$result = $stmt->get_result();

include '../layout/sidebar.php';
?>

<div class="container-fluid px-4">
    <h3 class="mt-4">Riwayat Kesehatan Siswa</h3>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="../dashboard/index.php">Dashboard</a></li>
        <li class="breadcrumb-item active"><?= htmlspecialchars($nama) ?></li>
    </ol>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-user me-1"></i> Data Kunjungan: <?= htmlspecialchars($nama) ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal & Waktu</th>
                            <th>Kelas</th>
                            <th>Keluhan</th>
                            <th>Pengobatan/Tindakan</th>
                            <th>Petugas Piket</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= date('d F Y, H:i', strtotime($row['tanggal'])) ?></td>
                            <td><?= $row['kelas'] ?></td>
                            <td><span class="text-danger"><?= $row['keluhan'] ?></span></td>
                            <td><?= $row['pengobatan'] ?? $row['Tindakan'] ?? '-' ?></td>
                            <td><strong><?= $row['petugas'] ?? 'Petugas' ?></strong></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <a href="../dashboard/index.php" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
        </div>
    </div>
</div>