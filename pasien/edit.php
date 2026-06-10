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

// Validasi ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

// Ambil data pasien berdasarkan ID
$stmt = $koneksi->prepare("SELECT * FROM pasien WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: index.php");
    exit();
}

$data = $result->fetch_assoc();
$stmt->close();

?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-edit"></i> Edit Data Pasien
                    </div>
                    <div class="card-body">
                        <form action="update.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['id']); ?>">

                            <div class="form-group mb-3">
                                <label for="nama" class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="kelas" name="kelas" value="<?php echo htmlspecialchars($data['kelas']); ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="keluhan" class="form-label">Keluhan <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="keluhan" name="keluhan" rows="3" required><?php echo htmlspecialchars($data['keluhan']); ?></textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label for="pengobatan" class="form-label">Pengobatan <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="pengobatan" name="pengobatan" rows="3" required><?php echo htmlspecialchars($data['pengobatan']); ?></textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label for="tanggal" class="form-label">Tanggal Kunjungan <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" id="tanggal" name="tanggal" 
                                       value="<?php echo date('Y-m-d\TH:i', strtotime($data['tanggal'])); ?>" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Update Data
                                </button>
                                <a href="index.php" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

