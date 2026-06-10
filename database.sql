-- ===================================
-- DATABASE: sikpu
-- APLIKASI: sikpu - Sistem Kunjungan Pasien UKS
-- ===================================

-- Buat Database
CREATE DATABASE IF NOT EXISTS sikpu;
USE sikpu;

-- ===================================
-- TABEL: petugas
-- ===================================
CREATE TABLE IF NOT EXISTS petugas (
    id_petugas INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_petugas VARCHAR(100) NOT NULL,
    jabatan VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================
-- TABEL: pasien
-- ===================================
CREATE TABLE IF NOT EXISTS pasien (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    kelas VARCHAR(20) NOT NULL,
    keluhan TEXT NOT NULL,
    pengobatan TEXT NOT NULL,
    tanggal DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================
-- INSERT DATA SAMPLE
-- ===================================

-- Insert Petugas (Username: petugas, Password: 123456)
INSERT INTO petugas (username, password, nama_petugas, jabatan) VALUES
('petugas', '123456', 'Ibu Siti Nurhaliza', 'Petugas UKS');

-- Insert Data Pasien Sample
INSERT INTO pasien (nama, kelas, keluhan, pengobatan, tanggal) VALUES
('Andi Wijaya', 'X-A', 'Sakit kepala dan pusing', 'Istirahat, diberikan obat pusing paracetamol', '2024-03-01 09:30:00'),
('Siti Nurhaliza', 'X-B', 'Demam tinggi 38° C', 'Diberikan obat penurun panas dan istirahat', '2024-03-02 10:15:00'),
('Budi Santoso', 'XI-A', 'Luka di tangan', 'Luka dibersihkan dan diberi obat luka, perban', '2024-03-03 11:00:00'),
('Rina Hidayah', 'X-C', 'Diare', 'Diberikan oralit dan obat anti diare', '2024-03-04 14:30:00'),
('Ahmad Syaiful', 'XI-B', 'Sakit gigi', 'Dikompres dengan air hangat, diberikan obat pereda nyeri', '2024-03-05 13:45:00');

-- ===================================
-- INDEX (untuk optimasi query)
-- ===================================
CREATE INDEX idx_petugas_username ON petugas(username);
CREATE INDEX idx_pasien_nama ON pasien(nama);
CREATE INDEX idx_pasien_kelas ON pasien(kelas);
CREATE INDEX idx_pasien_tanggal ON pasien(tanggal);
