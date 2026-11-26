<?php
/**
 * Login Panitia SPMB SMAN 1 Astanajapura
 */
session_start();
require_once __DIR__ . '/../config/database.php';

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = 'Username dan password wajib diisi.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id']        = $admin['id'];
            $_SESSION['admin_username']  = $admin['username'];
            $_SESSION['admin_nama']      = $admin['nama_lengkap'];
            $_SESSION['admin_role']      = $admin['role'];

            header('Location: index.php');
            exit;
        } else {
            $error = 'Username atau password yang Anda masukkan salah.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Panitia SPMB — SMAN 1 Astanajapura</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    .font-serif-title { font-family: 'Playfair Display', serif; }
  </style>
</head>
<body class="bg-[#0B1B3D] min-h-screen flex items-center justify-center p-4 font-sans text-slate-800">

  <div class="max-w-md w-full bg-white rounded-3xl p-8 sm:p-10 shadow-2xl border border-slate-100">
    
    <!-- School Brand Icon -->
    <div class="text-center mb-8">
      <div class="w-14 h-14 rounded-2xl bg-[#0F2744] text-white flex items-center justify-center mx-auto mb-3 shadow-lg shadow-[#0F2744]/20">
        <i data-lucide="shield-check" class="w-7 h-7 text-amber-400"></i>
      </div>
      <h1 class="text-2xl font-extrabold text-[#0F2744] font-serif-title">Portal Panitia SPMB</h1>
      <p class="text-xs text-slate-500 mt-1 font-medium">SMA Negeri 1 Astanajapura • Cirebon</p>
    </div>

    <?php if (!empty($error)): ?>
      <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold flex items-center gap-2">
        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
        <span><?= htmlspecialchars($error) ?></span>
      </div>
    <?php endif; ?>

    <form action="login.php" method="POST" class="space-y-5">
      <div>
        <label for="username" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Username</label>
        <div class="relative">
          <i data-lucide="user" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
          <input 
            type="text" 
            name="username" 
            id="username" 
            value="<?= htmlspecialchars($_POST['username'] ?? 'admin') ?>" 
            required 
            placeholder="Masukkan username" 
            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#0F2744]/20 focus:border-[#0F2744]"
          >
        </div>
      </div>

      <div>
        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Password</label>
        <div class="relative">
          <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
          <input 
            type="password" 
            name="password" 
            id="password" 
            value="<?= htmlspecialchars($_POST['password'] ?? 'admin123') ?>" 
            required 
            placeholder="Masukkan password" 
            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#0F2744]/20 focus:border-[#0F2744]"
          >
        </div>
        <p class="text-[11px] text-slate-400 mt-1">Default kredensial: <code>admin</code> / <code>admin123</code></p>
      </div>

      <button type="submit" class="w-full py-3 px-4 rounded-xl bg-[#0F2744] hover:bg-[#0B1B3D] text-white font-bold text-sm transition flex items-center justify-center gap-2 shadow-lg shadow-[#0F2744]/20">
        <i data-lucide="log-in" class="w-4 h-4"></i>
        <span>Masuk ke Dashboard</span>
      </button>
    </form>

    <div class="mt-8 pt-6 border-t border-slate-100 text-center">
      <a href="../index.php" class="text-xs text-slate-500 hover:text-slate-800 transition flex items-center justify-center gap-1">
        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
        <span>Kembali ke Halaman Utama</span>
      </a>
    </div>

  </div>

  <script>
    lucide.createIcons();
  </script>
</body>
</html>
