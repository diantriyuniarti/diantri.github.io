<?php
/**
 * Cek Status Kelulusan / Seleksi SPMB SMAN 1 Astanajapura
 */
require_once __DIR__ . '/config/database.php';

$query = trim($_GET['q'] ?? '');
$hasil = null;
$searched = false;

if (!empty($query)) {
    $searched = true;
    $stmt = $pdo->prepare("SELECT * FROM pendaftar WHERE no_pendaftaran = ? OR nisn = ? ORDER BY id DESC LIMIT 1");
    $stmt->execute([$query, $query]);
    $hasil = $stmt->fetch();
}

// Jika request via AJAX JSON
if (isset($_GET['ajax'])) {
    header('Content-Type: application/json');
    if ($hasil) {
        echo json_encode(['found' => true, 'data' => $hasil]);
    } else {
        echo json_encode(['found' => false, 'message' => 'Data pendaftar dengan nomor atau NISN tersebut tidak ditemukan.']);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cek Status Pendaftaran — SPMB SMAN 1 Astanajapura</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    .font-serif-title { font-family: 'Playfair Display', serif; }
  </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800 min-h-screen flex flex-col font-sans">

  <!-- Header -->
  <header class="bg-white border-b border-slate-200 sticky top-0 z-30">
    <div class="max-w-5xl mx-auto px-4 h-16 flex items-center justify-between">
      <a href="index.php" class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-[#0F2744] flex items-center justify-center text-white">
          <i data-lucide="graduation-cap" class="w-5 h-5"></i>
        </div>
        <div>
          <span class="font-bold text-[#0F2744] font-serif-title block leading-tight text-base sm:text-lg">SMAN 1 Astanajapura</span>
          <span class="text-xs text-slate-500 font-sans block">Kabupaten Cirebon</span>
        </div>
      </a>
      <a href="index.php" class="text-sm font-semibold text-[#0F2744] hover:underline flex items-center gap-1.5">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        <span>Kembali ke Beranda</span>
      </a>
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex-1 max-w-3xl w-full mx-auto px-4 py-12">
    
    <div class="text-center mb-8">
      <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-700 border border-amber-500/20 mb-3">
        <i data-lucide="search" class="w-3.5 h-3.5"></i>
        Portal Pengumuman & Seleksi
      </span>
      <h1 class="text-3xl font-extrabold text-[#0F2744] font-serif-title">
        Cek Status Pendaftaran SPMB
      </h1>
      <p class="text-slate-600 text-sm mt-2 max-w-md mx-auto">
        Masukkan Nomor Pendaftaran (contoh: <code>SPMB-2025-0001</code>) atau NISN 10 digit yang telah didaftarkan.
      </p>
    </div>

    <!-- Search Box -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm mb-8">
      <form action="cek_status.php" method="GET" class="space-y-4">
        <div>
          <label for="q" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor Pendaftaran / NISN</label>
          <div class="relative">
            <i data-lucide="search" class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
            <input 
              type="text" 
              name="q" 
              id="q" 
              value="<?= htmlspecialchars($query) ?>" 
              placeholder="Contoh: SPMB-2025-0001 atau 0091234567" 
              required
              class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0F2744]/20 focus:border-[#0F2744] text-slate-800 font-mono text-sm"
            >
          </div>
        </div>
        <button type="submit" class="w-full py-3 px-6 rounded-xl bg-[#0F2744] hover:bg-[#0B1B3D] text-white font-semibold text-sm transition flex items-center justify-center gap-2">
          <i data-lucide="search" class="w-4 h-4"></i>
          <span>Periksa Status Saya</span>
        </button>
      </form>
    </div>

    <!-- Hasil Pencarian -->
    <?php if ($searched): ?>
      <?php if ($hasil): ?>
        
        <?php
          $status = $hasil['status_pendaftaran'];
          $badge_color = 'bg-amber-100 text-amber-800 border-amber-300';
          $status_icon = 'clock';
          $status_desc = 'Berkas pendaftaran Anda telah masuk dan sedang dalam antrean verifikasi oleh panitia SPMB SMAN 1 Astanajapura.';

          if ($status === 'Berkas Terverifikasi') {
            $badge_color = 'bg-blue-100 text-blue-800 border-blue-300';
            $status_icon = 'file-check';
            $status_desc = 'Dokumen Anda dinyatakan lengkap dan valid. Silakan ikuti tes seleksi sesuai jadwal yang tertera pada bukti pendaftaran.';
          } elseif ($status === 'Lulus Seleksi') {
            $badge_color = 'bg-emerald-100 text-emerald-800 border-emerald-300';
            $status_icon = 'check-circle-2';
            $status_desc = 'Selamat! Anda dinyatakan LULUS SELEKSI sebagai Calon Peserta Didik Baru SMAN 1 Astanajapura Tahun Ajaran 2025/2026.';
          } elseif ($status === 'Tidak Lulus') {
            $badge_color = 'bg-rose-100 text-rose-800 border-rose-300';
            $status_icon = 'x-circle';
            $status_desc = 'Mohon maaf, Anda belum memenuhi kualifikasi seleksi pada periode ini.';
          }
        ?>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden animate-fade-in">
          
          <!-- Status Banner -->
          <div class="p-6 border-b border-slate-200 bg-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
              <span class="text-xs font-mono text-slate-500 uppercase">Status Seleksi Terkini:</span>
              <div class="mt-1">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-bold border <?= $badge_color ?>">
                  <i data-lucide="<?= $status_icon ?>" class="w-4 h-4"></i>
                  <span><?= htmlspecialchars($status) ?></span>
                </span>
              </div>
            </div>
            
            <a href="cetak_bukti.php?no=<?= urlencode($hasil['no_pendaftaran']) ?>" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800 transition">
              <i data-lucide="printer" class="w-4 h-4"></i>
              <span>Cetak Kartu Bukti</span>
            </a>
          </div>

          <!-- Description Box -->
          <div class="p-6 border-b border-slate-100 bg-white">
            <p class="text-sm text-slate-700 leading-relaxed">
              <?= $status_desc ?>
            </p>
            <?php if (!empty($hasil['catatan_admin'])): ?>
              <div class="mt-3 p-3 rounded-lg bg-amber-50 border border-amber-200 text-xs text-amber-900">
                <strong>Catatan Panitia:</strong> <?= htmlspecialchars($hasil['catatan_admin']) ?>
              </div>
            <?php endif; ?>
          </div>

          <!-- Details Table -->
          <div class="p-6">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4 font-mono">Data Terdaftar:</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
              <div class="p-3 rounded-lg bg-slate-50 border border-slate-100">
                <span class="text-xs text-slate-400 block font-mono">Nomor Pendaftaran</span>
                <span class="font-bold text-[#0F2744] font-mono text-base"><?= htmlspecialchars($hasil['no_pendaftaran']) ?></span>
              </div>
              <div class="p-3 rounded-lg bg-slate-50 border border-slate-100">
                <span class="text-xs text-slate-400 block font-mono">NISN</span>
                <span class="font-bold text-slate-800 font-mono"><?= htmlspecialchars($hasil['nisn']) ?></span>
              </div>
              <div class="p-3 rounded-lg bg-slate-50 border border-slate-100">
                <span class="text-xs text-slate-400 block">Nama Lengkap</span>
                <span class="font-bold text-slate-800"><?= htmlspecialchars($hasil['nama_lengkap']) ?></span>
              </div>
              <div class="p-3 rounded-lg bg-slate-50 border border-slate-100">
                <span class="text-xs text-slate-400 block">Program Studi Pilihan</span>
                <span class="font-bold text-[#0F2744]"><?= htmlspecialchars($hasil['program_studi']) ?></span>
              </div>
              <div class="p-3 rounded-lg bg-slate-50 border border-slate-100">
                <span class="text-xs text-slate-400 block">Sekolah Asal</span>
                <span class="font-semibold text-slate-700"><?= htmlspecialchars($hasil['asal_sekolah']) ?></span>
              </div>
              <div class="p-3 rounded-lg bg-slate-50 border border-slate-100">
                <span class="text-xs text-slate-400 block">Tanggal Mendaftar</span>
                <span class="text-slate-600 font-mono text-xs"><?= date('d F Y, H:i', strtotime($hasil['created_at'])) ?> WIB</span>
              </div>
            </div>
          </div>

        </div>

      <?php else: ?>
        
        <!-- Not Found Alert -->
        <div class="p-6 rounded-2xl bg-white border border-rose-200 text-center shadow-sm">
          <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-3">
            <i data-lucide="alert-circle" class="w-6 h-6"></i>
          </div>
          <h3 class="text-base font-bold text-slate-800">Data Pendaftar Tidak Ditemukan</h3>
          <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-md mx-auto">
            Tidak ditemukan pendaftar dengan nomor atau NISN <strong>"<?= htmlspecialchars($query) ?>"</strong>. Pastikan Anda memasukkan nomor dengan benar atau silakan lakukan pendaftaran baru.
          </p>
          <div class="mt-4">
            <a href="index.php#pendaftaran" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#0F2744] text-white text-xs font-semibold hover:bg-[#0B1B3D]">
              <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
              <span>Daftar Sekarang</span>
            </a>
          </div>
        </div>

      <?php endif; ?>
    <?php endif; ?>

  </main>

  <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500">
    © 2025 SMA Negeri 1 Astanajapura. Kabupaten Cirebon, Jawa Barat.
  </footer>

  <script>
    lucide.createIcons();
  </script>
</body>
</html>
