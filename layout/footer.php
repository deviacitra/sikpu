<?php
if (isset($noLayout) && $noLayout == true) {
    return; // ❌ hentikan footer
}
?>
</div><!-- End main-content -->

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">&copy; 2024 Sistem Informasi Kunjungan Pasien UKS</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Konfirmasi hapus data
        function confirmDelete(id, name) {
            if (confirm('Apakah Anda yakin ingin menghapus ' + name + '?')) {
                return true;
            }
            return false;
        }
    </script>
</body>
</html>