<?php
/**
 * Handler Update Status Pendaftar (Admin Only)
 */
session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $status = trim($_POST['status_pendaftaran'] ?? '');
    $catatan = trim($_POST['catatan_admin'] ?? '');

    $allowed_status = ['Menunggu Verifikasi', 'Berkas Terverifikasi', 'Lulus Seleksi', 'Tidak Lulus'];
    if ($id > 0 && in_array($status, $allowed_status)) {
        $stmt = $pdo->prepare("UPDATE pendaftar SET status_pendaftaran = ?, catatan_admin = ? WHERE id = ?");
        $stmt->execute([$status, $catatan, $id]);
    }
}

$ref = $_SERVER['HTTP_REFERER'] ?? 'index.php';
header("Location: {$ref}");
exit;
