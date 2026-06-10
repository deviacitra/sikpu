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

// 1. QUERY TOP 10 (Menghitung berdasarkan nama di tabel pasien)
$queryTop = mysqli_query($koneksi, "
    SELECT nama, COUNT(*) as total 
    FROM pasien 
    GROUP BY nama 
    ORDER BY total DESC 
    LIMIT 10
");

// 2. LOGIKA DATA GRAFIK (7 Hari Terakhir)
$label_grafik = [];
$data_grafik = [];
for ($i = 6; $i >= 0; $i--) {
    $tgl = date('Y-m-d', strtotime("-$i days"));
    $label_grafik[] = date('d M', strtotime($tgl)); 
    $sql_grafik = $koneksi->query("SELECT COUNT(*) as total FROM pasien WHERE DATE(tanggal) = '$tgl'");
    $res_grafik = $sql_grafik->fetch_assoc();
    $data_grafik[] = $res_grafik['total'];
}

// 3. STATISTIK CARD
$total = $koneksi->query("SELECT COUNT(*) as total FROM pasien")->fetch_assoc()['total'];
$hari_ini = date('Y-m-d');
$hari = $koneksi->query("SELECT COUNT(*) as total FROM pasien WHERE DATE(tanggal)='$hari_ini'")->fetch_assoc()['total'];
$bulan_ini = date('Y-m');
$bulan_card = $koneksi->query("SELECT COUNT(*) as total FROM pasien WHERE DATE_FORMAT(tanggal,'%Y-%m')='$bulan_ini'")->fetch_assoc()['total'];

// 4. KUNJUNGAN TERBARU (Join dengan petugas jika ada relasi)
// Asumsi: tabel pasien memiliki kolom 'id_petugas' atau nama petugas disimpan di sana
$data_rekap = $koneksi->query("SELECT * FROM pasien ORDER BY tanggal DESC LIMIT 5");

include '../layout/sidebar.php'; 
?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4 h3">Dashboard Utama</h1>
        <p class="text-muted mt-4"><?= date('l, d F Y') ?></p>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 border-start border-primary border-4 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Kunjungan</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total ?> Pasien</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 border-start border-success border-4 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Kunjungan Hari Ini</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $hari ?> Pasien</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 border-start border-info border-4 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Kunjungan Bulan Ini</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $bulan_card ?> Pasien</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-trophy me-2 text-warning"></i>Top 10 Siswa ke UKS</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php 
                        $no = 1; 
                        while($top = mysqli_fetch_assoc($queryTop)) : 
                            $bg = ($no == 1) ? 'bg-light' : '';
                        ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center <?= $bg ?>">
                            <div>
                                <small class="text-muted">#<?= $no++ ?></small>
                                <span class="ms-2 fw-bold"><?= $top['nama'] ?></span>
                                <div class="small text-muted ms-4"><?= $top['total'] ?> Kali Kunjungan</div>
                            </div>
                            <a href="../pasien/riwayat.php?nama=<?= urlencode($top['nama']) ?>" class="btn btn-sm btn-primary rounded-pill">Detail</a>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-chart-line me-2"></i>Tren Kunjungan 7 Hari Terakhir</h6>
                </div>
                <div class="card-body">
                    <canvas id="myChart" style="width:100%; height:320px;"></canvas>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-history me-2"></i>Kunjungan Terbaru</h6>
                    <a href="rekap.php" class="btn btn-sm btn-link">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Siswa</th>
                                    <th>Keluhan</th>
                                    <th>Waktu</th>
                                    <th>Petugas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $data_rekap->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold"><?= $row['nama'] ?></div>
                                        <div class="small text-muted"><?= $row['kelas'] ?></div>
                                    </td>
                                    <td><span class="badge bg-danger bg-opacity-10 text-danger"><?= $row['keluhan'] ?></span></td>
                                    <td class="small"><?= date('d M, H:i', strtotime($row['tanggal'])) ?></td>
                                    <td><small class="text-muted"><i class="fas fa-user-md me-1"></i><?= $row['petugas'] ?? 'Admin' ?></small></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('myChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($label_grafik) ?>,
        datasets: [{
            label: 'Jumlah Pasien',
            data: <?= json_encode($data_grafik) ?>,
            backgroundColor: 'rgba(13, 110, 253, 0.1)',
            borderColor: '#0d6efd',
            borderWidth: 3,
            pointBackgroundColor: '#0d6efd',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 } }
        }
    }
});
</script>
</body>
</html>