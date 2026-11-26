<?php
/**
 * Handler Pendaftaran Siswa Baru (SPMB SMAN 1 Astanajapura)
 */
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Metode permintaan tidak valid.'
    ]);
    exit;
}

// Ambil data POST
$nama_lengkap    = trim($_POST['nama_lengkap'] ?? '');
$jenis_kelamin   = trim($_POST['jenis_kelamin'] ?? '');
$tempat_lahir    = trim($_POST['tempat_lahir'] ?? '');
$tanggal_lahir   = trim($_POST['tanggal_lahir'] ?? '');
$asal_sekolah    = trim($_POST['asal_sekolah'] ?? '');
$nisn            = trim($_POST['nisn'] ?? '');
$program_studi   = trim($_POST['program_studi'] ?? '');
$nama_orang_tua  = trim($_POST['nama_orang_tua'] ?? '');
$nomor_telepon   = trim($_POST['nomor_telepon'] ?? '');
$email           = trim($_POST['email'] ?? '');
$alamat_lengkap  = trim($_POST['alamat_lengkap'] ?? '');

// Validasi Kelengkapan Field
$errors = [];
if (empty($nama_lengkap)) $errors[] = 'Nama lengkap wajib diisi.';
if (empty($jenis_kelamin)) $errors[] = 'Jenis kelamin wajib dipilih.';
if (empty($tempat_lahir)) $errors[] = 'Tempat lahir wajib diisi.';
if (empty($tanggal_lahir)) $errors[] = 'Tanggal lahir wajib diisi.';
if (empty($asal_sekolah)) $errors[] = 'Asal sekolah wajib diisi.';
if (empty($nisn)) $errors[] = 'NISN wajib diisi.';
if (empty($program_studi)) $errors[] = 'Program studi wajib dipilih.';
if (empty($nama_orang_tua)) $errors[] = 'Nama orang tua/wali wajib diisi.';
if (empty($nomor_telepon)) $errors[] = 'Nomor telepon/WhatsApp wajib diisi.';
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Alamat email tidak valid.';
if (empty($alamat_lengkap)) $errors[] = 'Alamat lengkap wajib diisi.';

if (!empty($errors)) {
    echo json_encode([
        'success' => false,
        'message' => 'Mohon lengkapi seluruh field dengan data yang valid.',
        'errors'  => $errors
    ]);
    exit;
}

try {
    // Generate Nomor Pendaftaran Otomatis: SPMB-2025-XXXX
    $tahun = date('Y');
    $stmt_count = $pdo->query("SELECT COUNT(*) FROM pendaftar");
    $total_pendaftar = (int)$stmt_count->fetchColumn() + 1;
    $no_pendaftaran = sprintf("SPMB-%s-%04d", $tahun, $total_pendaftar);

    // Cek agar tidak duplikat
    $cek_no = $pdo->prepare("SELECT COUNT(*) FROM pendaftar WHERE no_pendaftaran = ?");
    $cek_no->execute([$no_pendaftaran]);
    if ($cek_no->fetchColumn() > 0) {
        $no_pendaftaran = sprintf("SPMB-%s-%04d", $tahun, $total_pendaftar + rand(1, 99));
    }

    // Insert ke Database
    $sql = "INSERT INTO pendaftar (
        no_pendaftaran, nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir,
        asal_sekolah, nisn, program_studi, nama_orang_tua, nomor_telepon,
        email, alamat_lengkap, status_pendaftaran
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Menunggu Verifikasi')";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $no_pendaftaran,
        $nama_lengkap,
        $jenis_kelamin,
        $tempat_lahir,
        $tanggal_lahir,
        $asal_sekolah,
        $nisn,
        $program_studi,
        $nama_orang_tua,
        $nomor_telepon,
        $email,
        $alamat_lengkap
    ]);

    $last_id = $pdo->lastInsertId();

    echo json_encode([
        'success'        => true,
        'message'        => 'Pendaftaran Berhasil! Data Anda telah berhasil dikirim ke sistem SPMB SMAN 1 Astanajapura.',
        'no_pendaftaran' => $no_pendaftaran,
        'data' => [
            'id'             => $last_id,
            'no_pendaftaran' => $no_pendaftaran,
            'nama_lengkap'   => $nama_lengkap,
            'nisn'           => $nisn,
            'program_studi'  => $program_studi,
            'asal_sekolah'   => $asal_sekolah,
            'email'          => $email,
            'telepon'        => $nomor_telepon,
            'created_at'     => date('d-m-Y H:i:s')
        ]
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan sistem database: ' . $e->getMessage()
    ]);
}
