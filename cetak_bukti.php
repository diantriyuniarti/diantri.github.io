<?php
/**
 * Cetak Bukti Pendaftaran Resmi (Print-friendly / PDF Ready)
 * SMAN 1 Astanajapura SPMB 2025/2026
 */
require_once __DIR__ . '/config/database.php';

$no_pendaftaran = trim($_GET['no'] ?? '');

if (empty($no_pendaftaran)) {
    die("Nomor pendaftaran tidak disertakan.");
}

$stmt = $pdo->prepare("SELECT * FROM pendaftar WHERE no_pendaftaran = ?");
$stmt->execute([$no_pendaftaran]);
$pendaftar = $stmt->fetch();

if (!$pendaftar) {
    die("Data pendaftar dengan nomor '{$no_pendaftaran}' tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Bukti Pendaftaran SPMB - <?= htmlspecialchars($pendaftar['no_pendaftaran']) ?> - <?= htmlspecialchars($pendaftar['nama_lengkap']) ?></title>
  <style>
    body {
      font-family: 'Times New Roman', Times, serif;
      font-size: 13px;
      line-height: 1.5;
      color: #000;
      background: #f4f6f8;
      margin: 0;
      padding: 20px;
    }
    .print-container {
      max-width: 800px;
      margin: 0 auto;
      background: #fff;
      padding: 35px 45px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      border: 1px solid #ddd;
    }
    /* Kop Surat */
    .kop-surat {
      display: flex;
      align-items: center;
      border-bottom: 3px double #000;
      padding-bottom: 12px;
      margin-bottom: 20px;
    }
    .kop-logo {
      width: 75px;
      height: 75px;
      margin-right: 20px;
    }
    .kop-text {
      text-align: center;
      flex: 1;
    }
    .kop-text h4 {
      margin: 0;
      font-size: 14px;
      font-weight: normal;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .kop-text h3 {
      margin: 2px 0;
      font-size: 15px;
      font-weight: bold;
      text-transform: uppercase;
    }
    .kop-text h2 {
      margin: 3px 0;
      font-size: 18px;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    .kop-text p {
      margin: 0;
      font-size: 11px;
    }

    /* Judul Dokumen */
    .doc-title {
      text-align: center;
      margin-bottom: 20px;
    }
    .doc-title h2 {
      margin: 0;
      font-size: 16px;
      text-transform: uppercase;
      text-decoration: underline;
    }
    .doc-title p {
      margin: 4px 0 0 0;
      font-size: 13px;
      font-weight: bold;
      color: #1e3a8a;
    }

    /* Barcode / Reg Box */
    .reg-box {
      border: 2px solid #0f2744;
      background: #f8fafc;
      padding: 10px 15px;
      margin-bottom: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .reg-num {
      font-size: 18px;
      font-weight: bold;
      color: #0f2744;
      font-family: monospace;
    }
    .reg-status {
      display: inline-block;
      padding: 4px 10px;
      font-size: 11px;
      font-weight: bold;
      border-radius: 4px;
      background: #e2e8f0;
      color: #334155;
    }

    /* Tabel Data */
    table.data-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 25px;
    }
    table.data-table td {
      padding: 5px 8px;
      vertical-align: top;
    }
    table.data-table td.label {
      width: 28%;
      font-weight: bold;
    }
    table.data-table td.colon {
      width: 3%;
    }
    table.data-table tr:nth-child(even) {
      background: #fafafa;
    }

    /* Petunjuk */
    .notice-box {
      border: 1px dashed #64748b;
      padding: 10px 15px;
      font-size: 11px;
      margin-bottom: 30px;
      background: #fdfdfd;
    }
    .notice-box ol {
      margin: 5px 0 0 0;
      padding-left: 20px;
    }

    /* Tanda Tangan */
    .ttd-section {
      display: flex;
      justify-content: space-between;
      margin-top: 40px;
      padding: 0 30px;
    }
    .ttd-box {
      text-align: center;
      width: 220px;
    }
    .ttd-space {
      height: 70px;
    }

    /* Action bar */
    .action-bar {
      max-width: 800px;
      margin: 0 auto 15px auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .btn {
      padding: 8px 16px;
      font-size: 13px;
      border-radius: 6px;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-weight: bold;
      font-family: sans-serif;
    }
    .btn-print {
      background: #0f2744;
      color: #fff;
      border: none;
    }
    .btn-back {
      background: #e2e8f0;
      color: #1e293b;
      border: 1px solid #cbd5e1;
    }

    @media print {
      body {
        background: #fff;
        padding: 0;
      }
      .action-bar {
        display: none !important;
      }
      .print-container {
        box-shadow: none;
        border: none;
        padding: 0;
        width: 100%;
        max-width: 100%;
      }
    }
  </style>
</head>
<body>

  <!-- Action Bar Screen Only -->
  <div class="action-bar">
    <a href="index.php" class="btn btn-back">← Kembali ke Halaman Utama</a>
    <button onclick="window.print()" class="btn btn-print">🖨️ Cetak / Simpan PDF</button>
  </div>

  <div class="print-container">
    
    <!-- Kop Surat Resmi -->
    <div class="kop-surat">
      <!-- Lambang / Simbol Pendidikan Jawa Barat -->
      <svg class="kop-logo" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="50" cy="50" r="46" stroke="#0F2744" stroke-width="4" fill="#F8FAFC"/>
        <path d="M50 20 L20 35 L50 50 L80 35 Z" fill="#0F2744"/>
        <path d="M30 45 L30 65 Q50 78 70 65 L70 45" stroke="#0F2744" stroke-width="4" fill="none"/>
        <circle cx="50" cy="62" r="6" fill="#D97706"/>
      </svg>
      <div class="kop-text">
        <h4>Pemerintah Daerah Provinsi Jawa Barat</h4>
        <h3>Dinas Pendidikan • Cabang Dinas Wilayah X</h3>
        <h2>SMA Negeri 1 Astanajapura</h2>
        <p>Jl. KH. Wahid Hasyim No. 97, Kanci, Kec. Astanajapura, Kabupaten Cirebon, Jawa Barat 45181</p>
        <p>Telepon: (0231) 510398 | Website: sman1astanajapura.sch.id | Email: info@sman1astanajapura.sch.id</p>
      </div>
    </div>

    <!-- Judul Dokumen -->
    <div class="doc-title">
      <h2>Bukti Pendaftaran Peserta Didik Baru (SPMB)</h2>
      <p>Tahun Ajaran 2025 / 2026</p>
    </div>

    <!-- Registration Barcode & Status Box -->
    <div class="reg-box">
      <div>
        <div style="font-size: 11px; text-transform: uppercase; color: #64748b;">Nomor Pendaftaran Resmi:</div>
        <div class="reg-num"><?= htmlspecialchars($pendaftar['no_pendaftaran']) ?></div>
      </div>
      <div style="text-align: right;">
        <div style="font-size: 11px; color: #64748b; margin-bottom: 2px;">Status Berkas:</div>
        <span class="reg-status"><?= htmlspecialchars($pendaftar['status_pendaftaran']) ?></span>
      </div>
    </div>

    <!-- Tabel Rincian Data Siswa -->
    <table class="data-table">
      <tr>
        <td class="label">Nama Lengkap</td>
        <td class="colon">:</td>
        <td><strong><?= htmlspecialchars($pendaftar['nama_lengkap']) ?></strong></td>
      </tr>
      <tr>
        <td class="label">Nomor Induk Siswa Nasional (NISN)</td>
        <td class="colon">:</td>
        <td><?= htmlspecialchars($pendaftar['nisn']) ?></td>
      </tr>
      <tr>
        <td class="label">Jenis Kelamin</td>
        <td class="colon">:</td>
        <td><?= htmlspecialchars($pendaftar['jenis_kelamin']) ?></td>
      </tr>
      <tr>
        <td class="label">Tempat, Tanggal Lahir</td>
        <td class="colon">:</td>
        <td><?= htmlspecialchars($pendaftar['tempat_lahir']) ?>, <?= date('d F Y', strtotime($pendaftar['tanggal_lahir'])) ?></td>
      </tr>
      <tr>
        <td class="label">Asal Sekolah (SMP/MTs)</td>
        <td class="colon">:</td>
        <td><?= htmlspecialchars($pendaftar['asal_sekolah']) ?></td>
      </tr>
      <tr>
        <td class="label">Program Studi Pilihan</td>
        <td class="colon">:</td>
        <td><strong style="color: #0f2744;"><?= htmlspecialchars($pendaftar['program_studi']) ?></strong></td>
      </tr>
      <tr>
        <td class="label">Nama Orang Tua / Wali</td>
        <td class="colon">:</td>
        <td><?= htmlspecialchars($pendaftar['nama_orang_tua']) ?></td>
      </tr>
      <tr>
        <td class="label">Nomor Telepon / WhatsApp</td>
        <td class="colon">:</td>
        <td><?= htmlspecialchars($pendaftar['nomor_telepon']) ?></td>
      </tr>
      <tr>
        <td class="label">Alamat Email</td>
        <td class="colon">:</td>
        <td><?= htmlspecialchars($pendaftar['email']) ?></td>
      </tr>
      <tr>
        <td class="label">Alamat Tempat Tinggal</td>
        <td class="colon">:</td>
        <td><?= nl2br(htmlspecialchars($pendaftar['alamat_lengkap'])) ?></td>
      </tr>
      <tr>
        <td class="label">Waktu Pendaftaran</td>
        <td class="colon">:</td>
        <td><?= date('d-m-Y H:i:s', strtotime($pendaftar['created_at'])) ?> WIB</td>
      </tr>
    </table>

    <!-- Petunjuk Peserta -->
    <div class="notice-box">
      <strong>PETUNJUK & KETENTUAN PESERTA SPMB:</strong>
      <ol>
        <li>Cetak dan simpan lembar bukti pendaftaran ini sebagai syarat verifikasi dokumen fisik dan mengikuti tes seleksi.</li>
        <li>Bawa berkas persyaratan fisik (Fotokopi Akta Kelahiran, Kartu Keluarga, Rapor SMP, dan Pasfoto 3x4 2 lembar) saat jadwal verifikasi berkas (1 - 15 Maret 2025).</li>
        <li>Pantau pengumuman kelulusan berkala melalui menu <em>Cek Status Pendaftaran</em> pada portal web resmi dengan memasukkan Nomor Pendaftaran atau NISN.</li>
      </ol>
    </div>

    <!-- Tanda Tangan -->
    <div class="ttd-section">
      <div class="ttd-box">
        <div>Calon Peserta Didik,</div>
        <div class="ttd-space"></div>
        <div>( <strong><?= htmlspecialchars($pendaftar['nama_lengkap']) ?></strong> )</div>
      </div>

      <div class="ttd-box">
        <div>Astanajapura, <?= date('d F Y') ?><br>Panitia SPMB SMAN 1 Astanajapura</div>
        <div class="ttd-space"></div>
        <div>( <strong>Panitia Penerimaan</strong> )<br><span style="font-size: 11px;">NIP. 19820514 200801 1 008</span></div>
      </div>
    </div>

  </div>

</body>
</html>
