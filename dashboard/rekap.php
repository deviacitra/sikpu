<?php
define('BASE_URL', '../');
include '../config/koneksi.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Validasi login
if (!isset($_SESSION['id_petugas'])) {
    header("Location: " . BASE_URL . "auth/login.php");
    exit();
}

// Ambil filter dari URL (jika ada)
$filter_bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$filter_tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

// Bangun Query Dinamis
$query = "SELECT * FROM pasien WHERE 1=1";
if ($filter_bulan != '') {
    $query .= " AND MONTH(tanggal) = '$filter_bulan'";
}
if ($filter_tahun != '') {
    $query .= " AND YEAR(tanggal) = '$filter_tahun'";
}
$query .= " ORDER BY tanggal DESC";

$data = mysqli_query($koneksi, $query);
$total_data = mysqli_num_rows($data);

$namaBulan = [
    "01"=>"Januari","02"=>"Februari","03"=>"Maret","04"=>"April",
    "05"=>"Mei","06"=>"Juni","07"=>"Juli","08"=>"Agustus",
    "09"=>"September","10"=>"Oktober","11"=>"November","12"=>"Desember"
];

include '../layout/sidebar.php'; 
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fas fa-file-medical-alt"></i> Rekap Kunjungan Pasien</h3>
        <button onclick="window.print()" class="btn btn-secondary d-print-none">
            <i class="fas fa-print"></i> Cetak Laporan
        </button>
    </div>

    <div class="card shadow-sm p-3 mb-4 d-print-none">
        <form method="GET" class="row g-3 align-items-center">
            <div class="col-md-4">
                <label class="form-label">Filter Bulan</label>
                <select name="bulan" class="form-select">
                    <option value="">Semua Bulan (Tahunan)</option>
                    <?php foreach ($namaBulan as $key => $val): ?>
                        <option value="<?= $key ?>" <?= ($filter_bulan == $key) ? 'selected' : '' ?>><?= $val ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Filter Tahun</label>
                <select name="tahun" class="form-select">
                    <?php for ($t = 2020; $t <= date('Y'); $t++): ?>
                        <option value="<?= $t ?>" <?= ($filter_tahun == $t) ? 'selected' : '' ?>><?= $t ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-4 mt-auto">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Tampilkan Rekap
                </button>
            </div>
        </form>
    </div>

    <div class="card shadow">
        <div class="card-header bg-white">
            <h5 class="mb-0 text-center">
                LAPORAN KUNJUNGAN PASIEN UKS <br>
                <small class="text-muted">
                    <?= ($filter_bulan != '') ? "Bulan " . $namaBulan[$filter_bulan] : "Sepanjang" ?> Tahun <?= $filter_tahun ?>
                </small>
            </h5>
        </div>
        <div class="card-body">
            <p><strong>Total Kunjungan:</strong> <?= $total_data ?> Pasien</p>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Pasien</th>
                            <th>Kelas</th>
                            <th>Keluhan</th>
                            <th>Tindakan/Obat</th>
                            <th>Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($total_data > 0): ?>
                            <?php $no = 1; while($row = mysqli_fetch_assoc($data)): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                                <td><?= $row['nama'] ?></td>
                                <td class="text-center"><?= $row['kelas'] ?></td>
                                <td><?= $row['keluhan'] ?></td>
                                <td><?= $row['pengobatan'] ?></td>
                                <td><?= $row['petugas'] ?></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Data tidak ditemukan untuk periode ini.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
/* CSS Khusus Cetak agar rapi saat diprint */
@media print {
    .sidebar, .topbar, .d-print-none, .btn-primary { display: none !important; }
    .main-content { margin-left: 0 !important; padding: 0 !important; }
    .card { border: none !important; box-shadow: none !important; }
    body { background-color: white !important; }
}
</style>
