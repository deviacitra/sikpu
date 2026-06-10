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
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Tambah Data Pasien Baru</h5>
                </div>
                <div class="card-body p-4">
                    <form action="simpan.php" method="POST">
                        <div class="form-group mb-3">
                            <label for="nama" class="form-label fw-bold">Nama Siswa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama lengkap siswa" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="kelas" class="form-label fw-bold">Kelas <span class="text-danger">*</span></label>
                            <select class="form-select" id="kelas" name="kelas" required>
                                <option value="" selected disabled>-- Pilih Kelas --</option>
                                
                                <optgroup label="Kelas X">
                                    <option value="X-RPL 1">X-RPL 1</option>
                                    <option value="X-RPL 2">X-RPL 2</option>
                                    <option value="X-MP 1">X-MP 1</option>
                                    <option value="X-MP 2">X-MP 2</option>
                                    <option value="X-MP 3">X-MP 3</option>
                                    <option value="X-MP 4">X-MP 4</option>
                                    <option value="X-AK 1">X-AK 1</option>
                                    <option value="X-AK 2">X-AK 2</option>
                                    <option value="X-AK 3">X-AK 3</option>
                                    <option value="X-BD 1">X-BD 1</option>
                                    <option value="X-BD 2">X-BD 2</option>
                                    <option value="X-BD 3">X-BD 3</option>
                                    <option value="X-BD 4">X-BD 4</option>
                                    <option value="X-LP 1">X-LP 1</option>
                                    <option value="X-LP 2">X-LP 2</option>
                                </optgroup>

                                <optgroup label="Kelas XI">
                                    <option value="XI-RPL 1">XI-RPL 1</option>
                                    <option value="XI-RPL 2">XI-RPL 2</option>
                                    <option value="XI-MP 1">XI-MP 1</option>
                                    <option value="XI-MP 2">XI-MP 2</option>
                                    <option value="XI-MP 3">XI-MP 3</option>   
                                    <option value="XI-MP 4">XI-MP 4</option>
                                    <option value="XI-AK 1">XI-AK 1</option>
                                    <option value="XI-AK 2">XI-AK 2</option>
                                    <option value="XI-AK 3">XI-AK 3</option>
                                    <option value="XI-BD 1">XI-BD 1</option>
                                    <option value="XI-BD 2">XI-BD 2</option>
                                    <option value="XI-BD 3">XI-BD 3</option>
                                    <option value="XI-BD 4">XI-BD 4</option>
                                    <option value="XI-LP 1">XI-LP 1</option>
                                    <option value="XI-LP 2">XI-LP 2</option>
                                </optgroup>

                                <optgroup label="Kelas XII">
                                    <option value="XII-RPL 1">XII-RPL 1 </option>
                                    <option value="XII-RPL 2">XII-RPL 2</option>
                                    <option value="XII-MP 1">XII-MP 1</option>
                                    <option value="XII-MP 2">XII-MP 2</option>
                                    <option value="XII-MP 3">XII-MP 3</option>
                                    <option value="XII-MP 4">XII-MP 4</option>
                                    <option value="XII-AK 1">XII-AK 1</option>
                                    <option value="XII-AK 2">XII-AK 2</option>
                                    <option value="XII-AK 3">XII-AK 3</option>
                                    <option value="XII-BD 1">XII-BD 1</option>
                                    <option value="XII-BD 2">XII-BD 2</option>
                                    <option value="XII-BD 3">XII-BD 3</option>
                                    <option value="XII-BD 4">XII-BD 4</option>
                                    <option value="XII-LP 1">XII-LP 1</option>
                                    <option value="XII-LP 2">XII-LP 2</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="keluhan" class="form-label fw-bold">Keluhan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="keluhan" name="keluhan" rows="3" placeholder="Deskripsikan keluhan siswa" required></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="pengobatan" class="form-label fw-bold">Pengobatan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="pengobatan" name="pengobatan" rows="3" placeholder="Deskripsikan pengobatan yang diberikan" required></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="petugas" class="form-label fw-bold">Nama Petugas yang Menangani <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="petugas" name="petugas" placeholder="Masukkan nama petugas piket" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal" class="form-label fw-bold">Tanggal Kunjungan <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="tanggal" name="tanggal" required>
                                </div>
                            </div>
                            </div>
                        </div>

                        <hr>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save me-2"></i>Simpan Data
                            </button>
                            <a href="index.php" class="btn btn-light text-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Mengisi otomatis datetime-local dengan waktu saat ini
    window.onload = function() {
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        document.getElementById('tanggal').value = now.toISOString().slice(0, 16);
    };
</script>