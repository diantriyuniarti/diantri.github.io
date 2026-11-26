<?php
/**
 * Dashboard Admin Panitia SPMB SMAN 1 Astanajapura
 */
session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $del_id = (int)$_GET['id'];
    $stmt_del = $pdo->prepare("DELETE FROM pendaftar WHERE id = ?");
    $stmt_del->execute([$del_id]);
    header('Location: index.php?msg=deleted');
    exit;
}

// Filter & Pencarian
$search = trim($_GET['search'] ?? '');
$filter_prodi = trim($_GET['prodi'] ?? '');
$filter_status = trim($_GET['status'] ?? '');

$sql_where = [];
$params = [];

if (!empty($search)) {
    $sql_where[] = "(nama_lengkap LIKE ? OR no_pendaftaran LIKE ? OR nisn LIKE ? OR asal_sekolah LIKE ?)";
    $s_term = "%{$search}%";
    $params[] = $s_term;
    $params[] = $s_term;
    $params[] = $s_term;
    $params[] = $s_term;
}

if (!empty($filter_prodi)) {
    $sql_where[] = "program_studi = ?";
    $params[] = $filter_prodi;
}

if (!empty($filter_status)) {
    $sql_where[] = "status_pendaftaran = ?";
    $params[] = $filter_status;
}

$where_clause = !empty($sql_where) ? 'WHERE ' . implode(' AND ', $sql_where) : '';

// Ambil Daftar Pendaftar
$stmt_list = $pdo->prepare("SELECT * FROM pendaftar {$where_clause} ORDER BY id DESC");
$stmt_list->execute($params);
$pendaftar_list = $stmt_list->fetchAll();

// Hitung Statistik
$stat_total = $pdo->query("SELECT COUNT(*) FROM pendaftar")->fetchColumn();
$stat_menunggu = $pdo->query("SELECT COUNT(*) FROM pendaftar WHERE status_pendaftaran = 'Menunggu Verifikasi'")->fetchColumn();
$stat_terverifikasi = $pdo->query("SELECT COUNT(*) FROM pendaftar WHERE status_pendaftaran = 'Berkas Terverifikasi'")->fetchColumn();
$stat_lulus = $pdo->query("SELECT COUNT(*) FROM pendaftar WHERE status_pendaftaran = 'Lulus Seleksi'")->fetchColumn();

$stat_ipa = $pdo->query("SELECT COUNT(*) FROM pendaftar WHERE program_studi LIKE '%IPA%'")->fetchColumn();
$stat_ips = $pdo->query("SELECT COUNT(*) FROM pendaftar WHERE program_studi LIKE '%IPS%'")->fetchColumn();
$stat_bahasa = $pdo->query("SELECT COUNT(*) FROM pendaftar WHERE program_studi LIKE '%Bahasa%'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Panitia SPMB — SMAN 1 Astanajapura</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    .font-serif-title { font-family: 'Playfair Display', serif; }
  </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800 min-h-screen flex flex-col font-sans">

  <!-- Admin Top Navbar -->
  <header class="bg-[#0F2744] text-white border-b border-[#0B1B3D] sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-amber-400">
          <i data-lucide="graduation-cap" class="w-5 h-5"></i>
        </div>
        <div>
          <span class="font-bold font-serif-title text-base sm:text-lg block leading-tight">Panel Panitia SPMB</span>
          <span class="text-xs text-slate-300 font-sans block">SMAN 1 Astanajapura</span>
        </div>
      </div>

      <div class="flex items-center gap-4 text-xs">
        <a href="../index.php" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 text-slate-300 hover:text-white transition">
          <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
          <span>Lihat Portal Siswa</span>
        </a>
        <div class="h-4 w-px bg-white/20 hidden sm:block"></div>
        <div class="flex items-center gap-2">
          <span class="text-slate-200 font-medium"><?= htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin') ?></span>
          <a href="logout.php" onclick="return confirm('Apakah Anda yakin ingin keluar?')" class="p-1.5 rounded-lg bg-rose-500/20 text-rose-300 hover:bg-rose-500 hover:text-white transition" title="Logout">
            <i data-lucide="log-out" class="w-4 h-4"></i>
          </a>
        </div>
      </div>
    </div>
  </header>

  <!-- Dashboard Container -->
  <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 py-8 space-y-8">

    <!-- Welcome & Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <h1 class="text-2xl font-bold text-[#0F2744] font-serif-title">Manajemen Data Pendaftar 2025/2026</h1>
        <p class="text-xs text-slate-500 mt-0.5">Kelola verifikasi dokumen fisik, penetapan status kelulusan, dan rekapitulasi data pendaftar.</p>
      </div>

      <div class="flex items-center gap-2">
        <button onclick="window.print()" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
          <i data-lucide="printer" class="w-4 h-4"></i>
          <span>Cetak Rekap</span>
        </button>
      </div>
    </div>

    <!-- Statistik Cards Strip -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
          <i data-lucide="users" class="w-6 h-6"></i>
        </div>
        <div>
          <span class="text-xs text-slate-500 font-mono block">Total Pendaftar</span>
          <span class="text-2xl font-bold text-slate-900 font-mono"><?= $stat_total ?></span>
        </div>
      </div>

      <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
          <i data-lucide="clock" class="w-6 h-6"></i>
        </div>
        <div>
          <span class="text-xs text-slate-500 font-mono block">Menunggu Verifikasi</span>
          <span class="text-2xl font-bold text-amber-600 font-mono"><?= $stat_menunggu ?></span>
        </div>
      </div>

      <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
          <i data-lucide="file-check" class="w-6 h-6"></i>
        </div>
        <div>
          <span class="text-xs text-slate-500 font-mono block">Berkas Terverifikasi</span>
          <span class="text-2xl font-bold text-indigo-600 font-mono"><?= $stat_terverifikasi ?></span>
        </div>
      </div>

      <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
          <i data-lucide="check-circle" class="w-6 h-6"></i>
        </div>
        <div>
          <span class="text-xs text-slate-500 font-mono block">Lulus Seleksi</span>
          <span class="text-2xl font-bold text-emerald-600 font-mono"><?= $stat_lulus ?></span>
        </div>
      </div>
    </div>

    <!-- Pendaftar per Jurusan Mini Bar -->
    <div class="p-4 rounded-xl bg-slate-100 border border-slate-200 flex flex-wrap items-center justify-between gap-4 text-xs font-mono">
      <span class="font-bold text-slate-700 uppercase">Statistik Jurusan Pilihan:</span>
      <div class="flex items-center gap-6">
        <span>🔬 IPA: <strong><?= $stat_ipa ?></strong> siswa</span>
        <span>📈 IPS: <strong><?= $stat_ips ?></strong> siswa</span>
        <span>🌐 Bahasa: <strong><?= $stat_bahasa ?></strong> siswa</span>
      </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-sm">
      <form action="index.php" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
        <div class="sm:col-span-5 relative">
          <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
          <input 
            type="text" 
            name="search" 
            value="<?= htmlspecialchars($search) ?>" 
            placeholder="Cari nama, NISN, no daftar, asal sekolah..." 
            class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-[#0F2744]/20 focus:border-[#0F2744]"
          >
        </div>

        <div class="sm:col-span-3">
          <select name="prodi" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-[#0F2744]/20 focus:border-[#0F2744]">
            <option value="">Semua Program Studi</option>
            <option value="IPA (Ilmu Pengetahuan Alam)" <?= $filter_prodi === 'IPA (Ilmu Pengetahuan Alam)' ? 'selected' : '' ?>>IPA</option>
            <option value="IPS (Ilmu Pengetahuan Sosial)" <?= $filter_prodi === 'IPS (Ilmu Pengetahuan Sosial)' ? 'selected' : '' ?>>IPS</option>
            <option value="Bahasa dan Sastra" <?= $filter_prodi === 'Bahasa dan Sastra' ? 'selected' : '' ?>>Bahasa dan Sastra</option>
          </select>
        </div>

        <div class="sm:col-span-3">
          <select name="status" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-[#0F2744]/20 focus:border-[#0F2744]">
            <option value="">Semua Status</option>
            <option value="Menunggu Verifikasi" <?= $filter_status === 'Menunggu Verifikasi' ? 'selected' : '' ?>>Menunggu Verifikasi</option>
            <option value="Berkas Terverifikasi" <?= $filter_status === 'Berkas Terverifikasi' ? 'selected' : '' ?>>Berkas Terverifikasi</option>
            <option value="Lulus Seleksi" <?= $filter_status === 'Lulus Seleksi' ? 'selected' : '' ?>>Lulus Seleksi</option>
            <option value="Tidak Lulus" <?= $filter_status === 'Tidak Lulus' ? 'selected' : '' ?>>Tidak Lulus</option>
          </select>
        </div>

        <div class="sm:col-span-1 flex gap-1">
          <button type="submit" class="w-full py-2 bg-[#0F2744] hover:bg-[#0B1B3D] text-white rounded-xl text-xs font-semibold flex items-center justify-center">
            <i data-lucide="filter" class="w-3.5 h-3.5"></i>
          </button>
          <?php if (!empty($search) || !empty($filter_prodi) || !empty($filter_status)): ?>
            <a href="index.php" class="p-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs flex items-center justify-center" title="Reset Filter">
              <i data-lucide="x" class="w-3.5 h-3.5"></i>
            </a>
          <?php endif; ?>
        </div>
      </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse">
          <thead>
            <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-mono uppercase tracking-wider">
              <th class="p-3.5">No. Reg</th>
              <th class="p-3.5">Nama & NISN</th>
              <th class="p-3.5">JK</th>
              <th class="p-3.5">Asal Sekolah</th>
              <th class="p-3.5">Program Studi</th>
              <th class="p-3.5">Kontak</th>
              <th class="p-3.5">Status</th>
              <th class="p-3.5 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <?php if (empty($pendaftar_list)): ?>
              <tr>
                <td colspan="8" class="p-8 text-center text-slate-400">
                  <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 text-slate-300"></i>
                  <span>Tidak ada data pendaftar yang sesuai.</span>
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($pendaftar_list as $row): ?>
                <?php
                  $badge_class = 'bg-amber-100 text-amber-800';
                  if ($row['status_pendaftaran'] === 'Berkas Terverifikasi') $badge_class = 'bg-blue-100 text-blue-800';
                  elseif ($row['status_pendaftaran'] === 'Lulus Seleksi') $badge_class = 'bg-emerald-100 text-emerald-800';
                  elseif ($row['status_pendaftaran'] === 'Tidak Lulus') $badge_class = 'bg-rose-100 text-rose-800';
                ?>
                <tr class="hover:bg-slate-50/70 transition">
                  <td class="p-3.5 font-mono font-bold text-[#0F2744]">
                    <?= htmlspecialchars($row['no_pendaftaran']) ?>
                    <span class="block text-[10px] text-slate-400 font-normal"><?= date('d/m/Y', strtotime($row['created_at'])) ?></span>
                  </td>
                  <td class="p-3.5">
                    <strong class="text-slate-900 block"><?= htmlspecialchars($row['nama_lengkap']) ?></strong>
                    <span class="text-slate-400 font-mono text-[11px]">NISN: <?= htmlspecialchars($row['nisn']) ?></span>
                  </td>
                  <td class="p-3.5 text-slate-600"><?= $row['jenis_kelamin'] === 'Laki-laki' ? 'L' : 'P' ?></td>
                  <td class="p-3.5 text-slate-700"><?= htmlspecialchars($row['asal_sekolah']) ?></td>
                  <td class="p-3.5">
                    <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-medium text-[11px]"><?= htmlspecialchars($row['program_studi']) ?></span>
                  </td>
                  <td class="p-3.5 font-mono text-slate-600">
                    <div><?= htmlspecialchars($row['nomor_telepon']) ?></div>
                    <div class="text-[10px] text-slate-400 truncate max-w-[120px]"><?= htmlspecialchars($row['email']) ?></div>
                  </td>
                  <td class="p-3.5">
                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold <?= $badge_class ?> inline-block">
                      <?= htmlspecialchars($row['status_pendaftaran']) ?>
                    </span>
                  </td>
                  <td class="p-3.5 text-center">
                    <div class="inline-flex items-center gap-1.5">
                      <!-- Edit Status Button -->
                      <button 
                        onclick="openEditStatusModal(<?= htmlspecialchars(json_encode($row)) ?>)" 
                        class="p-1.5 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition" 
                        title="Ubah Status Verifikasi"
                      >
                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                      </button>

                      <!-- Cetak Bukti -->
                      <a 
                        href="../cetak_bukti.php?no=<?= urlencode($row['no_pendaftaran']) ?>" 
                        target="_blank" 
                        class="p-1.5 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition" 
                        title="Cetak Bukti Pendaftaran"
                      >
                        <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                      </a>

                      <!-- Delete -->
                      <a 
                        href="index.php?action=delete&id=<?= $row['id'] ?>" 
                        onclick="return confirm('Apakah Anda yakin ingin menghapus data pendaftar ini?')" 
                        class="p-1.5 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition" 
                        title="Hapus Data"
                      >
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </main>

  <!-- Edit Status Modal -->
  <div id="statusModal" class="fixed inset-0 z-50 bg-black/70 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 animate-fade-in">
      <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
        <div>
          <h3 class="font-bold text-[#0F2744] text-base">Verifikasi & Status Pendaftar</h3>
          <span id="modalNoReg" class="text-xs font-mono text-slate-400"></span>
        </div>
        <button onclick="closeStatusModal()" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-800">
          <i data-lucide="x" class="w-5 h-5"></i>
        </button>
      </div>

      <form action="update_status.php" method="POST" class="space-y-4">
        <input type="hidden" name="id" id="modalId">

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Pendaftar</label>
          <input type="text" id="modalNama" readonly class="w-full px-3 py-2 bg-slate-100 rounded-xl text-xs font-semibold text-slate-700 border border-slate-200 cursor-not-allowed">
        </div>

        <div>
          <label for="status_pendaftaran" class="block text-xs font-bold text-slate-700 uppercase mb-1">Pilih Status *</label>
          <select name="status_pendaftaran" id="modalStatus" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-[#0F2744]">
            <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
            <option value="Berkas Terverifikasi">Berkas Terverifikasi (Lolos Berkas)</option>
            <option value="Lulus Seleksi">Lulus Seleksi (Diterima)</option>
            <option value="Tidak Lulus">Tidak Lulus</option>
          </select>
        </div>

        <div>
          <label for="catatan_admin" class="block text-xs font-bold text-slate-700 uppercase mb-1">Catatan Panitia (Terlihat Siswa)</label>
          <textarea name="catatan_admin" id="modalCatatan" rows="3" placeholder="Contoh: Berkas telah diverifikasi, silakan bawa fotokopi rapor saat tes..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-[#0F2744]"></textarea>
        </div>

        <div class="pt-2 flex justify-end gap-2">
          <button type="button" onclick="closeStatusModal()" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200 transition">Batal</button>
          <button type="submit" class="px-5 py-2 rounded-xl bg-[#0F2744] text-white text-xs font-bold hover:bg-[#0B1B3D] transition">Simpan Status</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    lucide.createIcons();

    function openEditStatusModal(data) {
      document.getElementById('modalId').value = data.id;
      document.getElementById('modalNoReg').textContent = data.no_pendaftaran;
      document.getElementById('modalNama').value = data.nama_lengkap + ' (NISN: ' + data.nisn + ')';
      document.getElementById('modalStatus').value = data.status_pendaftaran;
      document.getElementById('modalCatatan').value = data.catatan_admin || '';
      
      const modal = document.getElementById('statusModal');
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    }

    function closeStatusModal() {
      const modal = document.getElementById('statusModal');
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }
  </script>
</body>
</html>
