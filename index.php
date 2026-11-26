<?php
/**
 * SPMB SMAN 1 Astanajapura - Web Penerimaan Peserta Didik Baru
 * Replika PHP & MySQL dari https://sekolah-spmb-siswa-ceria.lovable.app
 */
require_once __DIR__ . '/config/database.php';
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SPMB SMAN 1 Astanajapura — Pendaftaran Siswa Baru 2025/2026</title>
  <meta name="description" content="Penerimaan Peserta Didik Baru (SPMB) SMAN 1 Astanajapura Kabupaten Cirebon Tahun Ajaran 2025/2026. Daftar online sekarang untuk jurusan IPA, IPS, dan Bahasa.">
  
  <!-- Google Fonts: Playfair Display (Serif) & Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
            serif: ['"Playfair Display"', 'Georgia', 'serif'],
          },
          colors: {
            navy: {
              800: '#0F2744',
              900: '#0B1B3D',
              950: '#071228',
            },
            gold: {
              400: '#FBBF24',
              500: '#F59E0B',
              600: '#D97706',
            }
          }
        }
      }
    }
  </script>

  <style>
    .font-serif-title { font-family: 'Playfair Display', serif; }
    /* Toast animation */
    .toast-slide {
      animation: toastIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes toastIn {
      from { transform: translateY(30px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
  </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800 font-sans antialiased selection:bg-navy-800 selection:text-white">

  <!-- ==================== STICKY HEADER ==================== -->
  <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200 transition-all">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
      
      <!-- Brand Logo -->
      <a href="#hero" class="flex items-center gap-3.5 group">
        <div class="w-11 h-11 rounded-xl bg-navy-800 text-white flex items-center justify-center shadow-md shadow-navy-800/20 group-hover:bg-navy-900 transition">
          <i data-lucide="graduation-cap" class="w-6 h-6 text-gold-400"></i>
        </div>
        <div>
          <span class="font-bold text-navy-800 font-serif-title text-lg sm:text-xl block leading-tight tracking-tight">
            SMAN 1 Astanajapura
          </span>
          <span class="text-xs text-slate-500 font-sans block -mt-0.5 font-medium">
            Kabupaten Cirebon
          </span>
        </div>
      </a>

      <!-- Desktop Navigation Links -->
      <nav class="hidden lg:flex items-center gap-8 text-sm font-semibold text-slate-600">
        <a href="#hero" class="hover:text-navy-800 transition">Beranda</a>
        <a href="#tentang" class="hover:text-navy-800 transition">Tentang Kami</a>
        <a href="#program" class="hover:text-navy-800 transition">Program</a>
        <a href="#jadwal" class="hover:text-navy-800 transition">Jadwal</a>
        <a href="#pendaftaran" class="hover:text-navy-800 transition">Pendaftaran</a>
        <a href="cek_status.php" class="text-amber-700 hover:text-amber-800 transition flex items-center gap-1 font-bold">
          <i data-lucide="search" class="w-3.5 h-3.5"></i>
          <span>Cek Status</span>
        </a>
        <a href="#kontak" class="hover:text-navy-800 transition">Kontak</a>
      </nav>

      <!-- Action Buttons -->
      <div class="flex items-center gap-3">
        <a href="#pendaftaran" class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-xs sm:text-sm font-bold bg-navy-800 hover:bg-navy-900 text-white shadow-md shadow-navy-800/20 transition transform hover:-translate-y-0.5">
          <span>Daftar Sekarang</span>
          <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>

        <!-- Mobile Hamburger -->
        <button id="mobileMenuToggle" aria-label="Menu" class="lg:hidden p-2 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-100">
          <i data-lucide="menu" class="w-5 h-5"></i>
        </button>
      </div>

    </div>

    <!-- Mobile Dropdown -->
    <div id="mobileMenu" class="hidden lg:hidden border-t border-slate-200 bg-white px-5 py-4 space-y-3 text-sm font-semibold">
      <a href="#hero" class="block py-1 text-slate-700 hover:text-navy-800">Beranda</a>
      <a href="#tentang" class="block py-1 text-slate-700 hover:text-navy-800">Tentang Kami</a>
      <a href="#program" class="block py-1 text-slate-700 hover:text-navy-800">Program Studi</a>
      <a href="#jadwal" class="block py-1 text-slate-700 hover:text-navy-800">Jadwal SPMB</a>
      <a href="#pendaftaran" class="block py-1 text-slate-700 hover:text-navy-800">Formulir Pendaftaran</a>
      <a href="cek_status.php" class="block py-1 text-amber-700 font-bold">Cek Status Kelulusan</a>
      <a href="#kontak" class="block py-1 text-slate-700 hover:text-navy-800">Kontak Sekolah</a>
      <a href="#pendaftaran" class="block text-center mt-2 px-4 py-2.5 rounded-full bg-navy-800 text-white text-xs font-bold">Daftar Sekarang</a>
    </div>
  </header>

  <main>
    <!-- ==================== HERO SECTION ==================== -->
    <section id="hero" class="relative bg-gradient-to-br from-navy-950 via-navy-900 to-navy-800 text-white pt-24 pb-20 sm:pt-32 sm:pb-28 overflow-hidden">
      <!-- Background Pattern Grid -->
      <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-3xl space-y-6 text-center sm:text-left">
          
          <!-- Pill Badge -->
          <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold bg-gold-500/20 text-gold-400 border border-gold-400/30">
            <span class="w-2 h-2 rounded-full bg-gold-400 animate-pulse"></span>
            <span>Pendaftaran Tahun Ajaran 2025/2026 Dibuka!</span>
          </div>

          <!-- Headline (Playfair Display) -->
          <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight font-serif-title leading-[1.12]">
            Masa Depan Cerah <br />
            <span class="text-gold-400 italic">Dimulai di Sini</span>
          </h1>

          <!-- Sub-headline -->
          <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl">
            SMA Negeri 1 Astanajapura berkomitmen membentuk generasi unggul yang berakhlak mulia, berprestasi akademik, dan siap menghadapi tantangan global.
          </p>

          <!-- CTA Buttons -->
          <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4 pt-2">
            <a href="#pendaftaran" class="inline-flex items-center gap-2.5 px-8 py-3.5 rounded-full text-sm font-bold bg-gold-500 hover:bg-gold-400 text-slate-950 shadow-xl shadow-gold-500/20 transition transform hover:-translate-y-0.5">
              <span>Daftar Sekarang</span>
              <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
            <a href="#tentang" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full text-sm font-semibold bg-white/10 hover:bg-white/15 text-white border border-white/20 transition">
              <span>Pelajari Lebih Lanjut</span>
            </a>
            <a href="cek_status.php" class="inline-flex items-center gap-2 px-5 py-3.5 rounded-full text-sm font-semibold text-gold-400 hover:text-white transition">
              <i data-lucide="search" class="w-4 h-4"></i>
              <span>Cek Status Seleksi</span>
            </a>
          </div>

          <!-- 3 Floating Counter Stats -->
          <div class="grid grid-cols-3 gap-4 pt-10 border-t border-white/10 max-w-xl text-left">
            <div>
              <div class="text-2xl sm:text-3xl font-extrabold text-gold-400 font-serif-title">1,200+</div>
              <div class="text-xs text-slate-300 mt-0.5">Siswa Aktif</div>
            </div>
            <div>
              <div class="text-2xl sm:text-3xl font-extrabold text-white font-serif-title">50+</div>
              <div class="text-xs text-slate-300 mt-0.5">Prestasi Diraih</div>
            </div>
            <div>
              <div class="text-2xl sm:text-3xl font-extrabold text-gold-400 font-serif-title">25</div>
              <div class="text-xs text-slate-300 mt-0.5">Tahun Berdiri</div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- ==================== TENTANG KAMI SECTION ==================== -->
    <section id="tentang" class="py-20 bg-white border-b border-slate-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-16">
          <span class="inline-block px-3.5 py-1 rounded-full text-xs font-bold bg-navy-800/10 text-navy-800 uppercase tracking-wider mb-3">
            Tentang Kami
          </span>
          <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-800 font-serif-title">
            Membangun Generasi <span class="text-gold-600 italic">Unggul</span> di Astanajapura
          </h2>
          <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
            Berdiri sejak puluhan tahun di Kabupaten Cirebon, SMA Negeri 1 Astanajapura terus berdedikasi melahirkan lulusan berkompeten, berkarakter santun, dan siap bersaing di perguruan tinggi negeri maupun dunia profesional.
          </p>
        </div>

        <!-- 3 Pilar: Visi, Misi, Nilai -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
          
          <div class="p-8 rounded-3xl bg-slate-50 border border-slate-200 shadow-sm space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-navy-800 text-white flex items-center justify-center">
              <i data-lucide="eye" class="w-6 h-6 text-gold-400"></i>
            </div>
            <h3 class="text-xl font-bold text-navy-800 font-serif-title">Visi Sekolah</h3>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
              Menjadi sekolah unggulan yang menghasilkan lulusan berkualitas, berakhlak mulia, dan berdaya saing global dengan berlandaskan nilai-nilai kearifan lokal.
            </p>
          </div>

          <div class="p-8 rounded-3xl bg-slate-50 border border-slate-200 shadow-sm space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-navy-800 text-white flex items-center justify-center">
              <i data-lucide="compass" class="w-6 h-6 text-gold-400"></i>
            </div>
            <h3 class="text-xl font-bold text-navy-800 font-serif-title">Misi Sekolah</h3>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
              Menyelenggarakan pendidikan berkualitas dengan mengedepankan inovasi pembelajaran, pembinaan karakter religius, disiplin, dan pengembangan potensi minat bakat.
            </p>
          </div>

          <div class="p-8 rounded-3xl bg-slate-50 border border-slate-200 shadow-sm space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-navy-800 text-white flex items-center justify-center">
              <i data-lucide="award" class="w-6 h-6 text-gold-400"></i>
            </div>
            <h3 class="text-xl font-bold text-navy-800 font-serif-title">Nilai Utama</h3>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
              Menjunjung tinggi integritas, profesionalisme guru, kreativitas peserta didik, semangat kerjasama, dan komitmen mencapai keunggulan bersama.
            </p>
          </div>

        </div>

        <!-- 6 Keunggulan Kami (Checklist) -->
        <div class="p-8 sm:p-10 rounded-3xl bg-navy-900 text-white relative overflow-hidden">
          <div class="relative z-10 max-w-4xl">
            <span class="text-xs font-bold text-gold-400 uppercase tracking-widest block mb-2 font-mono">Fasilitas & Keunggulan</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold font-serif-title mb-6">Mengapa Memilih SMAN 1 Astanajapura?</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-xs sm:text-sm">
              <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/10">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-400 shrink-0"></i>
                <span>Kurikulum Merdeka Terintegrasi</span>
              </div>
              <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/10">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-400 shrink-0"></i>
                <span>Laboratorium IPA & Komputer Lengkap</span>
              </div>
              <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/10">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-400 shrink-0"></i>
                <span>20+ Kegiatan Ekstrakurikuler Aktif</span>
              </div>
              <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/10">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-400 shrink-0"></i>
                <span>Tenaga Pendidik Bersertifikasi</span>
              </div>
              <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/10">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-400 shrink-0"></i>
                <span>Sarana Olahraga & Perpustakaan Digital</span>
              </div>
              <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/10">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-400 shrink-0"></i>
                <span>Program Bimbingan Masuk PTN Unggulan</span>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- ==================== PROGRAM STUDI SECTION ==================== -->
    <section id="program" class="py-20 bg-[#F0F7FF] border-b border-slate-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-16">
          <span class="inline-block px-3.5 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-700 uppercase tracking-wider mb-3">
            Program Studi
          </span>
          <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-800 font-serif-title">
            Pilih Jalur <span class="text-gold-600 italic">Kesuksesanmu</span>
          </h2>
          <p class="text-slate-600 text-sm sm:text-base mt-3">
            Tersedia 3 peminatan yang dirancang untuk memfasilitasi minat, bakat, serta cita-cita karier masa depan siswa.
          </p>
        </div>

        <!-- 3 Jurusan Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
          
          <!-- IPA -->
          <div class="p-8 rounded-3xl bg-white border border-slate-200 shadow-sm flex flex-col justify-between space-y-6 hover:shadow-lg transition">
            <div class="space-y-4">
              <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <i data-lucide="atom" class="w-6 h-6"></i>
              </div>
              <div>
                <h3 class="text-xl font-bold text-navy-800 font-serif-title">IPA (Ilmu Pengetahuan Alam)</h3>
                <p class="text-xs text-slate-500 mt-1">Fokus pada eksplorasi sains, bioteknologi, fisika, dan matematika lanjutan dengan riset laboratorium.</p>
              </div>
              <ul class="text-xs text-slate-600 space-y-2 pt-2 border-t border-slate-100">
                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-blue-500"></i> Fisika & Kimia Terapan</li>
                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-blue-500"></i> Biologi & Ekosistem</li>
                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-blue-500"></i> Matematika Peminatan</li>
              </ul>
            </div>
            <a href="#pendaftaran" onclick="selectProdi('IPA (Ilmu Pengetahuan Alam)')" class="text-center py-2.5 px-4 rounded-xl text-xs font-bold bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white transition">
              Pilih Jurusan IPA →
            </a>
          </div>

          <!-- IPS -->
          <div class="p-8 rounded-3xl bg-white border border-slate-200 shadow-sm flex flex-col justify-between space-y-6 hover:shadow-lg transition">
            <div class="space-y-4">
              <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <i data-lucide="trending-up" class="w-6 h-6"></i>
              </div>
              <div>
                <h3 class="text-xl font-bold text-navy-800 font-serif-title">IPS (Ilmu Pengetahuan Sosial)</h3>
                <p class="text-xs text-slate-500 mt-1">Mempelajari dinamika sosial humaniora, ekonomi modern, akuntansi, hukum, dan geopolitik global.</p>
              </div>
              <ul class="text-xs text-slate-600 space-y-2 pt-2 border-t border-slate-100">
                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-amber-500"></i> Ekonomi & Akuntansi Dasar</li>
                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-amber-500"></i> Sosiologi & Antropologi</li>
                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-amber-500"></i> Geografi & Sejarah Peminatan</li>
              </ul>
            </div>
            <a href="#pendaftaran" onclick="selectProdi('IPS (Ilmu Pengetahuan Sosial)')" class="text-center py-2.5 px-4 rounded-xl text-xs font-bold bg-amber-50 text-amber-700 hover:bg-amber-600 hover:text-white transition">
              Pilih Jurusan IPS →
            </a>
          </div>

          <!-- Bahasa -->
          <div class="p-8 rounded-3xl bg-white border border-slate-200 shadow-sm flex flex-col justify-between space-y-6 hover:shadow-lg transition">
            <div class="space-y-4">
              <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i data-lucide="globe" class="w-6 h-6"></i>
              </div>
              <div>
                <h3 class="text-xl font-bold text-navy-800 font-serif-title">Bahasa dan Sastra</h3>
                <p class="text-xs text-slate-500 mt-1">Mengasah keterampilan komunikasi global, sastra nusantara, dan penguasaan bahasa asing unggulan.</p>
              </div>
              <ul class="text-xs text-slate-600 space-y-2 pt-2 border-t border-slate-100">
                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> Bahasa & Sastra Indonesia</li>
                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> Bahasa Inggris Lanjutan</li>
                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> Bahasa Asing (Jepang / Mandarin)</li>
              </ul>
            </div>
            <a href="#pendaftaran" onclick="selectProdi('Bahasa dan Sastra')" class="text-center py-2.5 px-4 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white transition">
              Pilih Jurusan Bahasa →
            </a>
          </div>

        </div>

      </div>
    </section>

    <!-- ==================== JADWAL & TIMELINE SECTION ==================== -->
    <section id="jadwal" class="py-20 bg-white border-b border-slate-200">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-16">
          <span class="inline-block px-3.5 py-1 rounded-full text-xs font-bold bg-navy-800/10 text-navy-800 uppercase tracking-wider mb-3">
            Alur Pendaftaran
          </span>
          <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-800 font-serif-title">
            Jadwal SPMB Tahun 2025
          </h2>
          <p class="text-slate-600 text-sm mt-2">
            Catat tanggal penting tahapan seleksi penerimaan murid baru SMAN 1 Astanajapura.
          </p>
        </div>

        <div class="space-y-6 relative before:absolute before:inset-0 before:left-8 sm:before:left-1/2 before:w-0.5 before:bg-slate-200">
          
          <!-- Tahap 1 -->
          <div class="relative flex flex-col sm:flex-row items-center gap-6 group">
            <div class="sm:w-1/2 sm:text-right pr-0 sm:pr-8 pl-16 sm:pl-0">
              <span class="text-xs font-bold font-mono text-gold-600">1 Januari – 28 Februari 2025</span>
              <h3 class="text-lg font-bold text-navy-800 mt-0.5">Pendaftaran Online Mandiri</h3>
              <p class="text-xs text-slate-500 mt-1">Mengisi formulir digital pada portal resmi ini dan mendapatkan nomor pendaftaran bukti registrasi.</p>
            </div>
            <div class="absolute left-6 sm:left-1/2 -translate-x-1/2 w-5 h-5 rounded-full bg-navy-800 border-4 border-white shadow"></div>
            <div class="sm:w-1/2 pl-16 sm:pl-8">
              <span class="inline-block px-3 py-1 text-xs font-bold rounded-lg bg-emerald-100 text-emerald-800">Tahap Sedang Dibuka</span>
            </div>
          </div>

          <!-- Tahap 2 -->
          <div class="relative flex flex-col sm:flex-row items-center gap-6 group">
            <div class="sm:w-1/2 sm:text-right pr-0 sm:pr-8 pl-16 sm:pl-0 order-2 sm:order-1">
              <span class="inline-block px-3 py-1 text-xs font-semibold rounded-lg bg-slate-100 text-slate-700">Verifikasi Fisik</span>
            </div>
            <div class="absolute left-6 sm:left-1/2 -translate-x-1/2 w-5 h-5 rounded-full bg-slate-400 border-4 border-white shadow"></div>
            <div class="sm:w-1/2 pl-16 sm:pl-8 order-1 sm:order-2">
              <span class="text-xs font-bold font-mono text-slate-500">1 – 15 Maret 2025</span>
              <h3 class="text-lg font-bold text-navy-800 mt-0.5">Verifikasi Dokumen & Berkas</h3>
              <p class="text-xs text-slate-500 mt-1">Pemeriksaan kelengkapan berkas fisik (Akta, KK, Rapor) oleh tim panitia di kampus SMAN 1 Astanajapura.</p>
            </div>
          </div>

          <!-- Tahap 3 -->
          <div class="relative flex flex-col sm:flex-row items-center gap-6 group">
            <div class="sm:w-1/2 sm:text-right pr-0 sm:pr-8 pl-16 sm:pl-0">
              <span class="text-xs font-bold font-mono text-slate-500">20 – 25 Maret 2025</span>
              <h3 class="text-lg font-bold text-navy-800 mt-0.5">Tes Seleksi Akademik & Minat Bakat</h3>
              <p class="text-xs text-slate-500 mt-1">Pelaksanaan asesmen akademik berbasis komputer dan wawancara peminatan jurusan.</p>
            </div>
            <div class="absolute left-6 sm:left-1/2 -translate-x-1/2 w-5 h-5 rounded-full bg-slate-400 border-4 border-white shadow"></div>
            <div class="sm:w-1/2 pl-16 sm:pl-8">
              <span class="inline-block px-3 py-1 text-xs font-semibold rounded-lg bg-slate-100 text-slate-700">Tahap Ujian</span>
            </div>
          </div>

          <!-- Tahap 4 -->
          <div class="relative flex flex-col sm:flex-row items-center gap-6 group">
            <div class="sm:w-1/2 sm:text-right pr-0 sm:pr-8 pl-16 sm:pl-0 order-2 sm:order-1">
              <span class="inline-block px-3 py-1 text-xs font-semibold rounded-lg bg-slate-100 text-slate-700">Registrasi Akhir</span>
            </div>
            <div class="absolute left-6 sm:left-1/2 -translate-x-1/2 w-5 h-5 rounded-full bg-slate-400 border-4 border-white shadow"></div>
            <div class="sm:w-1/2 pl-16 sm:pl-8 order-1 sm:order-2">
              <span class="text-xs font-bold font-mono text-slate-500">1 – 15 April 2025</span>
              <h3 class="text-lg font-bold text-navy-800 mt-0.5">Pengumuman & Daftar Ulang</h3>
              <p class="text-xs text-slate-500 mt-1">Pengumuman hasil kelulusan resmi via portal web dan administrasi daftar ulang calon siswa terpilih.</p>
            </div>
          </div>

          <!-- Tahap 5 -->
          <div class="relative flex flex-col sm:flex-row items-center gap-6 group">
            <div class="sm:w-1/2 sm:text-right pr-0 sm:pr-8 pl-16 sm:pl-0">
              <span class="text-xs font-bold font-mono text-slate-500">Juli 2025</span>
              <h3 class="text-lg font-bold text-navy-800 mt-0.5">Mulai Pembelajaran & MPLS</h3>
              <p class="text-xs text-slate-500 mt-1">Masa Pengenalan Lingkungan Sekolah (MPLS) dan dimulainya kegiatan belajar mengajar aktif.</p>
            </div>
            <div class="absolute left-6 sm:left-1/2 -translate-x-1/2 w-5 h-5 rounded-full bg-slate-400 border-4 border-white shadow"></div>
            <div class="sm:w-1/2 pl-16 sm:pl-8">
              <span class="inline-block px-3 py-1 text-xs font-semibold rounded-lg bg-slate-100 text-slate-700">Tahun Ajaran Baru</span>
            </div>
          </div>

        </div>

      </div>
    </section>

    <!-- ==================== FORMULIR PENDAFTARAN SECTION ==================== -->
    <section id="pendaftaran" class="py-20 bg-[#F8FAFC]">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-12">
          <span class="inline-block px-3.5 py-1 rounded-full text-xs font-bold bg-blue-500/10 text-blue-700 uppercase tracking-wider mb-3">
            Formulir Pendaftaran
          </span>
          <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-800 font-serif-title">
            Daftar <span class="text-gold-600 italic">Sekarang</span>
          </h2>
          <p class="text-slate-600 text-sm mt-2">
            Isi formulir pendaftaran di bawah ini dengan data yang valid dan lengkap sesuai dokumen resmi Anda.
          </p>
        </div>

        <!-- FORM CONTAINER -->
        <div id="formSection" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-8">
          
          <!-- Alert Box -->
          <div id="formAlert" class="hidden p-4 rounded-2xl text-xs font-semibold"></div>

          <form id="spmbForm" class="space-y-8">
            
            <!-- 1. DATA PRIBADI -->
            <div class="space-y-4">
              <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 text-navy-800 font-bold text-base">
                <div class="p-2 rounded-xl bg-navy-800/10 text-navy-800">
                  <i data-lucide="user" class="w-4 h-4"></i>
                </div>
                <span>1. Data Pribadi Calon Siswa</span>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                  <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap *</label>
                  <input type="text" name="nama_lengkap" required placeholder="Masukkan nama lengkap sesuai ijazah" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-800/20 focus:border-navy-800">
                </div>

                <div>
                  <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jenis Kelamin *</label>
                  <select name="jenis_kelamin" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-800/20 focus:border-navy-800 bg-white">
                    <option value="">Pilih jenis kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                </div>

                <div>
                  <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tempat Lahir *</label>
                  <input type="text" name="tempat_lahir" required placeholder="Masukkan kota/kabupaten lahir" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-800/20 focus:border-navy-800">
                </div>

                <div class="sm:col-span-2">
                  <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Lahir *</label>
                  <input type="date" name="tanggal_lahir" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-800/20 focus:border-navy-800">
                </div>
              </div>
            </div>

            <!-- 2. DATA PENDIDIKAN -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
              <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 text-navy-800 font-bold text-base">
                <div class="p-2 rounded-xl bg-navy-800/10 text-navy-800">
                  <i data-lucide="school" class="w-4 h-4"></i>
                </div>
                <span>2. Data Pendidikan & Pilihan Jurusan</span>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Asal Sekolah (SMP / MTs) *</label>
                  <input type="text" name="asal_sekolah" required placeholder="Contoh: SMP Negeri 1 Astanajapura" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-800/20 focus:border-navy-800">
                </div>

                <div>
                  <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">NISN (10 Digit) *</label>
                  <input type="text" name="nisn" required maxlength="10" placeholder="Masukkan 10 digit NISN" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-800/20 focus:border-navy-800 font-mono">
                </div>

                <div class="sm:col-span-2">
                  <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Program Studi Pilihan *</label>
                  <select name="program_studi" id="prodiSelect" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-800/20 focus:border-navy-800 bg-white font-medium text-navy-800">
                    <option value="">Pilih program studi</option>
                    <option value="IPA (Ilmu Pengetahuan Alam)">IPA (Ilmu Pengetahuan Alam)</option>
                    <option value="IPS (Ilmu Pengetahuan Sosial)">IPS (Ilmu Pengetahuan Sosial)</option>
                    <option value="Bahasa dan Sastra">Bahasa dan Sastra</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- 3. DATA KONTAK -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
              <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 text-navy-800 font-bold text-base">
                <div class="p-2 rounded-xl bg-navy-800/10 text-navy-800">
                  <i data-lucide="phone-call" class="w-4 h-4"></i>
                </div>
                <span>3. Data Orang Tua & Kontak</span>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                  <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Orang Tua / Wali *</label>
                  <input type="text" name="nama_orang_tua" required placeholder="Masukkan nama ayah / ibu / wali" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-800/20 focus:border-navy-800">
                </div>

                <div>
                  <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Telepon / WhatsApp *</label>
                  <input type="tel" name="nomor_telepon" required placeholder="Contoh: 081234567890" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-800/20 focus:border-navy-800 font-mono">
                </div>

                <div>
                  <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email *</label>
                  <input type="email" name="email" required placeholder="nama@email.com" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-800/20 focus:border-navy-800">
                </div>

                <div class="sm:col-span-2">
                  <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Lengkap Tempat Tinggal *</label>
                  <textarea name="alamat_lengkap" rows="3" required placeholder="Masukkan nama jalan, RT/RW, Dusun, Desa/Kelurahan, dan Kecamatan" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-800/20 focus:border-navy-800"></textarea>
                </div>
              </div>
            </div>

            <!-- Submit Button & Disclaimer -->
            <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
              <span class="text-xs text-slate-500 text-center sm:text-left">
                * Wajib diisi. Pastikan data yang dimasukkan telah sesuai dengan dokumen asli.
              </span>
              
              <button type="submit" id="submitBtn" class="w-full sm:w-auto px-8 py-3.5 rounded-2xl bg-navy-800 hover:bg-navy-900 text-white font-bold text-sm transition flex items-center justify-center gap-2 shadow-lg shadow-navy-800/20">
                <i data-lucide="send" class="w-4 h-4"></i>
                <span id="btnText">Kirim Pendaftaran</span>
              </button>
            </div>

          </form>
        </div>

        <!-- SUCCESS VIEW (REPLACES FORM ON SUCCESS) -->
        <div id="successCard" class="hidden bg-white rounded-3xl p-8 sm:p-12 border border-slate-200 shadow-xl text-center space-y-6">
          <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto shadow-inner">
            <i data-lucide="check-circle-2" class="w-10 h-10"></i>
          </div>

          <div>
            <span class="text-xs font-bold font-mono text-emerald-600 uppercase tracking-wider">Pendaftaran Berhasil</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-navy-800 font-serif-title mt-1">
              Selamat, Data Anda Telah Diterima!
            </h3>
            <p class="text-xs sm:text-sm text-slate-600 mt-2 max-w-md mx-auto">
              Terima kasih telah mendaftar di SMAN 1 Astanajapura. Simpan bukti pendaftaran Anda untuk dibawa saat verifikasi berkas.
            </p>
          </div>

          <!-- Highlight Registration Box -->
          <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 max-w-lg mx-auto text-left space-y-3 font-mono text-xs">
            <div class="flex justify-between items-center pb-2 border-b border-slate-200">
              <span class="text-slate-500">Nomor Registrasi:</span>
              <strong id="resNoDaftar" class="text-base text-navy-800 font-bold"></strong>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-slate-500">Nama Lengkap:</span>
              <span id="resNama" class="text-slate-800 font-bold"></span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-slate-500">NISN:</span>
              <span id="resNisn" class="text-slate-800"></span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-slate-500">Program Pilihan:</span>
              <span id="resProdi" class="text-navy-800 font-bold"></span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-slate-500">Asal Sekolah:</span>
              <span id="resSekolah" class="text-slate-800"></span>
            </div>
          </div>

          <!-- Actions -->
          <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
            <a id="btnCetakBukti" href="#" target="_blank" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-navy-800 text-white font-bold text-xs sm:text-sm shadow-md hover:bg-navy-900 transition">
              <i data-lucide="printer" class="w-4 h-4"></i>
              <span>Cetak Kartu Bukti Pendaftaran (PDF)</span>
            </a>
            
            <button onclick="resetRegistrationForm()" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs sm:text-sm transition">
              <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
              <span>Daftar Siswa Lain</span>
            </button>
          </div>
        </div>

      </div>
    </section>

  </main>

  <!-- ==================== FOOTER ==================== -->
  <footer id="kontak" class="bg-navy-950 text-white pt-16 pb-12 border-t border-navy-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-12 border-b border-white/10">
        
        <!-- Col 1: Brand & Address -->
        <div class="md:col-span-5 space-y-4">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-navy-800 text-white flex items-center justify-center">
              <i data-lucide="graduation-cap" class="w-5 h-5 text-gold-400"></i>
            </div>
            <div>
              <span class="font-bold text-lg font-serif-title block">SMAN 1 Astanajapura</span>
              <span class="text-xs text-slate-400 block">Kabupaten Cirebon, Jawa Barat</span>
            </div>
          </div>

          <p class="text-xs text-slate-400 leading-relaxed max-w-sm">
            Jl. KH. Wahid Hasyim No.97, Kanci, Kec. Astanajapura, Kabupaten Cirebon, Jawa Barat 45181.
          </p>

          <div class="text-xs text-slate-400 space-y-1 font-mono">
            <div>Telepon: (0231) 510398</div>
            <div>Email: info@sman1astanajapura.sch.id</div>
            <div>Jam Operasional: Senin – Jumat (07.00 – 16.00 WIB)</div>
          </div>
        </div>

        <!-- Col 2: Tautan Cepat -->
        <div class="md:col-span-3 space-y-3 text-xs">
          <span class="font-bold uppercase tracking-widest text-gold-400 block font-mono">Tautan Cepat</span>
          <ul class="space-y-2 text-slate-300">
            <li><a href="#hero" class="hover:text-gold-400 transition">Beranda Utama</a></li>
            <li><a href="#tentang" class="hover:text-gold-400 transition">Profil & Visi Misi</a></li>
            <li><a href="#program" class="hover:text-gold-400 transition">Pilihan Program Studi</a></li>
            <li><a href="#jadwal" class="hover:text-gold-400 transition">Alur & Jadwal SPMB</a></li>
            <li><a href="cek_status.php" class="hover:text-gold-400 transition">Pengumuman & Cek Status</a></li>
          </ul>
        </div>

        <!-- Col 3: Portal Panitia -->
        <div class="md:col-span-4 space-y-3 text-xs">
          <span class="font-bold uppercase tracking-widest text-gold-400 block font-mono">Akses Panitia SPMB</span>
          <p class="text-slate-400 leading-relaxed">
            Khusus guru dan panitia penerimaan siswa baru untuk memverifikasi dokumen berkas pendaftaran dan menetapkan kelulusan.
          </p>
          <div class="pt-1">
            <a href="admin/login.php" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold transition border border-white/10">
              <i data-lucide="lock" class="w-3.5 h-3.5 text-gold-400"></i>
              <span>Login Portal Admin</span>
            </a>
          </div>
        </div>

      </div>

      <!-- Copyright -->
      <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
        <div>
          © 2025 SMA Negeri 1 Astanajapura. Hak Cipta Dilindungi.
        </div>
        <div class="flex items-center gap-4">
          <a href="#hero" class="hover:text-slate-300 transition">Kembali ke Atas ↑</a>
          <span>•</span>
          <a href="admin/login.php" class="hover:text-slate-300 transition">Portal Panitia</a>
        </div>
      </div>

    </div>
  </footer>

  <!-- Floating Toast Notification -->
  <div id="toastNotification" class="fixed bottom-6 right-6 z-50 hidden max-w-sm w-full p-4 rounded-2xl shadow-2xl text-xs font-semibold toast-slide"></div>

  <!-- ==================== JAVASCRIPT ==================== -->
  <script>
    lucide.createIcons();

    // Mobile menu toggle
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    mobileMenuToggle.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
    mobileMenu.querySelectorAll('a').forEach(a => {
      a.addEventListener('click', () => mobileMenu.classList.add('hidden'));
    });

    // Helper untuk memilih prodi dari kartu jurusan
    function selectProdi(val) {
      const select = document.getElementById('prodiSelect');
      if (select) {
        select.value = val;
      }
    }

    // Toast function
    function showToast(message, isSuccess = true) {
      const toast = document.getElementById('toastNotification');
      toast.className = 'fixed bottom-6 right-6 z-50 max-w-sm w-full p-4 rounded-2xl shadow-2xl text-xs font-semibold toast-slide flex items-center gap-3 ' + 
        (isSuccess ? 'bg-emerald-600 text-white border border-emerald-500' : 'bg-rose-600 text-white border border-rose-500');
      
      toast.innerHTML = `
        <i data-lucide="${isSuccess ? 'check-circle' : 'alert-circle'}" class="w-5 h-5 shrink-0"></i>
        <span>${message}</span>
      `;
      toast.classList.remove('hidden');
      lucide.createIcons();

      setTimeout(() => {
        toast.classList.add('hidden');
      }, 5000);
    }

    // AJAX Form Handling
    const form = document.getElementById('spmbForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const formSection = document.getElementById('formSection');
    const successCard = document.getElementById('successCard');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      submitBtn.disabled = true;
      btnText.textContent = 'Memproses Pendaftaran...';

      const formData = new FormData(form);

      try {
        const response = await fetch('proses_daftar.php', {
          method: 'POST',
          body: formData
        });

        const result = await response.json();

        if (result.success) {
          showToast(result.message, true);
          
          // Isi data ke Success Card
          document.getElementById('resNoDaftar').textContent = result.data.no_pendaftaran;
          document.getElementById('resNama').textContent = result.data.nama_lengkap;
          document.getElementById('resNisn').textContent = result.data.nisn;
          document.getElementById('resProdi').textContent = result.data.program_studi;
          document.getElementById('resSekolah').textContent = result.data.asal_sekolah;
          
          // Link Cetak Bukti
          document.getElementById('btnCetakBukti').href = 'cetak_bukti.php?no=' + encodeURIComponent(result.data.no_pendaftaran);

          // Tukar tampilan
          formSection.classList.add('hidden');
          successCard.classList.remove('hidden');
          successCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
          showToast(result.message || 'Gagal mengirim pendaftaran.', false);
        }
      } catch (err) {
        showToast('Terjadi kesalahan jaringan atau server.', false);
      } finally {
        submitBtn.disabled = false;
        btnText.textContent = 'Kirim Pendaftaran';
      }
    });

    function resetRegistrationForm() {
      form.reset();
      successCard.classList.add('hidden');
      formSection.classList.remove('hidden');
      formSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  </script>
</body>
</html>
