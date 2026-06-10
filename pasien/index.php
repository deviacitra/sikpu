<?php
define('BASE_URL', '../');
include '../config/koneksi.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id_petugas'])) {
    header("Location: " . BASE_URL . "auth/login.php");
    exit();
}

// Pencarian
$cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';

// Query data pasien
if ($cari != '') {
    $stmt = $koneksi->prepare("SELECT * FROM pasien WHERE nama LIKE ? OR kelas LIKE ? ORDER BY tanggal DESC");
    $search = "%$cari%";
    $stmt->bind_param("ss", $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $koneksi->query("SELECT * FROM pasien ORDER BY tanggal DESC");
}
?>

<?php include '../layout/sidebar.php'; ?>

    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-8">
                <h3 class="mb-4">
                    <i class="fas fa-list"></i> Data Pasien
                </h3>
            </div>
            <div class="col-lg-4">
                <a href="<?php echo BASE_URL . 'pasien/tambah.php'; ?>" class="btn btn-success btn-sm float-end">
                    <i class="fas fa-plus"></i> Tambah Pasien
                </a>
                <a href="<?php echo BASE_URL . 'dashboard/index.php'; ?>" class="btn btn-secondary btn-sm float-end me-2">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </div>
        </div>

        <!-- Pencarian -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="" class="row g-2">
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="cari" placeholder="Cari nama atau kelas..." 
                               value="<?php echo htmlspecialchars($cari); ?>">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Data Pasien -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-table"></i> Daftar Kunjungan Pasien
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Keluhan</th>
                            <th>Pengobatan</th>
                            <th>Tanggal</th>
                            <th>Petugas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                        <tbody>
                        <?php 
                        $no = 1;
                        while($row = $result->fetch_assoc()): 
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="fw-bold"><?= $row['nama'] ?></td>
                            <td><?= $row['kelas'] ?></td>
                            <td><?= $row['keluhan'] ?></td>
                            <td><?= $row['pengobatan'] ?></td>
                            <td class="small"><?= date('d/m/Y - H:i', strtotime($row['tanggal'])) ?> WIB</td>
                            
                            <td><?= $row['petugas'] ?? '-' ?></td>

                            <td>
                                <div class="d-flex gap-1">
                                    <a href="riwayat.php?nama=<?= urlencode($row['nama']) ?>" class="btn btn-sm btn-info text-white" title="Riwayat">
                                        <i class="fas fa-history"></i>
                                    </a>
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning text-white" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


