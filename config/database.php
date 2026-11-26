<?php
/**
 * Konfigurasi Database PDO (MySQL dengan Smart Auto-Setup & Fallback)
 * SMAN 1 Astanajapura SPMB
 */

$host = '127.0.0.1';
$port = '3306';
$db_name = 'spmb_sman1_astanajapura';
$username = 'root';
$password = '';

$pdo = null;
$db_type = 'mysql';

try {
    // 1. Coba hubungkan ke MySQL Server
    $dsn_server = "mysql:host={$host};port={$port};charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 2, // Timeout cepat jika MySQL belum running
    ];

    $pdo_temp = new PDO($dsn_server, $username, $password, $options);
    
    // Pastikan database ada
    $pdo_temp->exec("CREATE DATABASE IF NOT EXISTS `{$db_name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo_temp = null;

    // Hubungkan langsung ke database
    $dsn_db = "mysql:host={$host};port={$port};dbname={$db_name};charset=utf8mb4";
    $pdo = new PDO($dsn_db, $username, $password, $options);
    $db_type = 'mysql';

    // Auto-create tabel jika belum ada
    init_mysql_tables($pdo);

} catch (PDOException $e) {
    // 2. Jika MySQL tidak berjalan / belum dinyalakan di XAMPP,
    // gunakan SQLite lokal secara otomatis agar aplikasi tetap bisa langsung diuji!
    try {
        $sqlite_file = __DIR__ . '/../database.sqlite';
        $pdo = new PDO("sqlite:" . $sqlite_file);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $db_type = 'sqlite';

        init_sqlite_tables($pdo);
    } catch (PDOException $e_sqlite) {
        die("Koneksi Database Gagal: " . $e_sqlite->getMessage());
    }
}

/**
 * Inisialisasi tabel MySQL
 */
function init_mysql_tables($pdo) {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `admin` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `username` VARCHAR(50) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `nama_lengkap` VARCHAR(100) NOT NULL,
            `role` VARCHAR(20) DEFAULT 'admin',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");

    $pdo->exec("
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
    ");

    // Insert default admin jika belum ada
    $stmt = $pdo->query("SELECT COUNT(*) FROM `admin` WHERE `username` = 'admin'");
    if ($stmt->fetchColumn() == 0) {
        $hash = password_hash('admin123', PASSWORD_BCRYPT);
        $stmt_ins = $pdo->prepare("INSERT INTO `admin` (`username`, `password`, `nama_lengkap`, `role`) VALUES ('admin', ?, 'Panitia SPMB SMAN 1 Astanajapura', 'admin')");
        $stmt_ins->execute([$hash]);
    }
}

/**
 * Inisialisasi tabel SQLite
 */
function init_sqlite_tables($pdo) {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS admin (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            nama_lengkap TEXT NOT NULL,
            role TEXT DEFAULT 'admin',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS pendaftar (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            no_pendaftaran TEXT NOT NULL UNIQUE,
            nama_lengkap TEXT NOT NULL,
            jenis_kelamin TEXT NOT NULL,
            tempat_lahir TEXT NOT NULL,
            tanggal_lahir DATE NOT NULL,
            asal_sekolah TEXT NOT NULL,
            nisn TEXT NOT NULL,
            program_studi TEXT NOT NULL,
            nama_orang_tua TEXT NOT NULL,
            nomor_telepon TEXT NOT NULL,
            email TEXT NOT NULL,
            alamat_lengkap TEXT NOT NULL,
            status_pendaftaran TEXT DEFAULT 'Menunggu Verifikasi',
            catatan_admin TEXT DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
    ");

    // Insert default admin jika belum ada
    $stmt = $pdo->query("SELECT COUNT(*) FROM admin WHERE username = 'admin'");
    if ($stmt->fetchColumn() == 0) {
        $hash = password_hash('admin123', PASSWORD_BCRYPT);
        $stmt_ins = $pdo->prepare("INSERT INTO admin (username, password, nama_lengkap, role) VALUES ('admin', ?, 'Panitia SPMB SMAN 1 Astanajapura', 'admin')");
        $stmt_ins->execute([$hash]);
    }

    // Insert sample data jika kosong
    $stmt_p = $pdo->query("SELECT COUNT(*) FROM pendaftar");
    if ($stmt_p->fetchColumn() == 0) {
        $pdo->exec("
            INSERT INTO pendaftar (no_pendaftaran, nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, asal_sekolah, nisn, program_studi, nama_orang_tua, nomor_telepon, email, alamat_lengkap, status_pendaftaran)
            VALUES 
            ('SPMB-2025-0001', 'Ahmad Rizky Pratama', 'Laki-laki', 'Cirebon', '2009-04-12', 'SMP Negeri 1 Astanajapura', '0091234567', 'IPA (Ilmu Pengetahuan Alam)', 'Bambang Pratama', '081234567890', 'ahmad.rizky@gmail.com', 'Jl. KH. Wahid Hasyim No. 12, Kanci, Astanajapura, Cirebon', 'Lulus Seleksi'),
            ('SPMB-2025-0002', 'Siti Nurhaliza', 'Perempuan', 'Cirebon', '2009-08-20', 'SMP Negeri 2 Lemahabang', '0098765432', 'IPS (Ilmu Pengetahuan Sosial)', 'H. Supardi', '085712345678', 'siti.nurhaliza@gmail.com', 'Desa Mertapada Wetan, Kec. Astanajapura, Cirebon', 'Berkas Terverifikasi'),
            ('SPMB-2025-0003', 'Fajar Ramadhan', 'Laki-laki', 'Kuningan', '2009-11-05', 'MTs Negeri 1 Cirebon', '0094567890', 'Bahasa dan Sastra', 'Ahmad Fauzi', '087890123456', 'fajar.ramadhan@gmail.com', 'Jl. Raya Cirebon-Losari KM 15, Astanajapura', 'Menunggu Verifikasi');
        ");
    }
}
