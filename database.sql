-- ========================================================
-- SISTEM PENERIMAAN MURID BARU (SPMB)
-- SMA NEGERI 1 ASTANAJAPURA - KABUPATEN CIREBON
-- Database Schema (MySQL)
-- ========================================================

CREATE DATABASE IF NOT EXISTS `spmb_sman1_astanajapura` 
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `spmb_sman1_astanajapura`;

-- 1. TABEL ADMIN / PANITIA SPMB
CREATE TABLE IF NOT EXISTS `admin` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `nama_lengkap` VARCHAR(100) NOT NULL,
  `role` VARCHAR(20) DEFAULT 'admin',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Password default: 'admin123'
INSERT INTO `admin` (`username`, `password`, `nama_lengkap`, `role`)
VALUES 
('admin', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 'Panitia SPMB SMAN 1 Astanajapura', 'admin')
ON DUPLICATE KEY UPDATE `username`=`username`;


-- 2. TABEL PENDAFTAR SISWA BARU
CREATE TABLE IF NOT EXISTS `pendaftar` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `no_pendaftaran` VARCHAR(30) NOT NULL UNIQUE,
  `nama_lengkap` VARCHAR(150) NOT NULL,
  `jenis_kelamin` ENUM('Laki-laki', 'Perempuan') NOT NULL,
  `tempat_lahir` VARCHAR(100) NOT NULL,
  `tanggal_lahir` DATE NOT NULL,
  `asal_sekolah` VARCHAR(150) NOT NULL,
  `nisn` VARCHAR(20) NOT NULL,
  `program_studi` VARCHAR(50) NOT NULL,
  `nama_orang_tua` VARCHAR(150) NOT NULL,
  `nomor_telepon` VARCHAR(25) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `alamat_lengkap` TEXT NOT NULL,
  `status_pendaftaran` ENUM('Menunggu Verifikasi', 'Berkas Terverifikasi', 'Lulus Seleksi', 'Tidak Lulus') DEFAULT 'Menunggu Verifikasi',
  `catatan_admin` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data Dummy Contoh untuk Pengujian Awal
INSERT INTO `pendaftar` (
  `no_pendaftaran`, `nama_lengkap`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, 
  `asal_sekolah`, `nisn`, `program_studi`, `nama_orang_tua`, `nomor_telepon`, 
  `email`, `alamat_lengkap`, `status_pendaftaran`
) VALUES 
('SPMB-2025-0001', 'Ahmad Rizky Pratama', 'Laki-laki', 'Cirebon', '2009-04-12', 'SMP Negeri 1 Astanajapura', '0091234567', 'IPA (Ilmu Pengetahuan Alam)', 'Bambang Pratama', '081234567890', 'ahmad.rizky@gmail.com', 'Jl. KH. Wahid Hasyim No. 12, Kanci, Astanajapura, Cirebon', 'Lulus Seleksi'),
('SPMB-2025-0002', 'Siti Nurhaliza', 'Perempuan', 'Cirebon', '2009-08-20', 'SMP Negeri 2 Lemahabang', '0098765432', 'IPS (Ilmu Pengetahuan Sosial)', 'H. Supardi', '085712345678', 'siti.nurhaliza@gmail.com', 'Desa Mertapada Wetan, Kec. Astanajapura, Cirebon', 'Berkas Terverifikasi'),
('SPMB-2025-0003', 'Fajar Ramadhan', 'Laki-laki', 'Kuningan', '2009-11-05', 'MTs Negeri 1 Cirebon', '0094567890', 'Bahasa dan Sastra', 'Ahmad Fauzi', '087890123456', 'fajar.ramadhan@gmail.com', 'Jl. Raya Cirebon-Losari KM 15, Astanajapura', 'Menunggu Verifikasi')
ON DUPLICATE KEY UPDATE `no_pendaftaran`=`no_pendaftaran`;
