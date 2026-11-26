# Aplikasi Web SPMB SMAN 1 Astanajapura (PHP & MySQL)

Sistem Informasi Penerimaan Peserta Didik Baru (SPMB) SMA Negeri 1 Astanajapura, Kabupaten Cirebon, Jawa Barat.  
Direplikasi dan disempurnakan dari konsep [sekolah-spmb-siswa-ceria.lovable.app](https://sekolah-spmb-siswa-ceria.lovable.app) menjadi aplikasi full-stack dinamis berbasis **PHP dan MySQL**.

---

## 🌟 Fitur Utama

1. **Halaman Utama (Landing Page)**:
   - **Hero Section**: Headline sekolah, tombol pendaftaran, dan counter data statistik (1.200+ Siswa, 50+ Prestasi, 25 Tahun Berdiri).
   - **Profil & Visi Misi**: 3 Pilar (Visi, Misi, Nilai) dan 6 fasilitas keunggulan sekolah.
   - **Pilihan Program Studi**: Peminatan IPA, IPS, dan Bahasa & Sastra beserta kurikulum unggulan.
   - **Timeline Jadwal SPMB 2025**: Alur tahapan mulai dari Pendaftaran Online, Verifikasi Berkas, Tes Seleksi, hingga Daftar Ulang.
   - **Formulir Pendaftaran Online Interaktif**: Validasi formulir real-time dengan AJAX tanpa reload halaman.
   - **Kartu Sukses & Cetak Bukti**: Setelah mendaftar, calon siswa otomatis memperoleh **Nomor Pendaftaran Resmi** dan tombol cetak bukti pendaftaran.

2. **Cetak Bukti Pendaftaran Resmi (`cetak_bukti.php`)**:
   - Dilengkapi kop surat resmi Pemerintah Provinsi Jawa Barat, Dinas Pendidikan Cabang Wilayah X, SMAN 1 Astanajapura.
   - Format print-friendly / PDF-ready (`window.print()`).

3. **Cek Status Seleksi & Pengumuman (`cek_status.php`)**:
   - Calon siswa dapat melacak status berkas dan hasil seleksi (Menunggu Verifikasi, Berkas Terverifikasi, Lulus Seleksi, Tidak Lulus) secara mandiri hanya dengan menginput Nomor Pendaftaran atau NISN.

4. **Portal Panitia & Dashboard Admin (`admin/`)**:
   - **Autentikasi Login Panitia** dengan enkripsi password `bcrypt`.
   - **Dashboard Statistik**: Total pendaftar, jumlah per jurusan (IPA, IPS, Bahasa), dan per status kelulusan.
   - **Filter & Pencarian**: Filter berdasarkan jurusan dan status, serta pencarian instan (nama, NISN, sekolah asal).
   - **Manajemen Verifikasi**: Panitia dapat mengubah status pendaftar dan menambahkan catatan khusus yang tampil di kartu pengumuman siswa.
   - **Cetak Rekapitulasi Data**: Fasilitas cetak laporan panitia.

---

## 🚀 Cara Menjalankan

### Cara 1: Menggunakan PHP Built-in Server (Paling Cepat & Praktis)
1. Buka terminal (PowerShell / Command Prompt).
2. Masuk ke folder proyek:
   ```bash
   cd C:\Users\diant\.gemini\antigravity\scratch\spmb-sman1-astanajapura
   ```
3. Jalankan server PHP:
   ```bash
   php -S localhost:8000
   ```
4. Buka browser dan akses:
   - Portal Calon Siswa: `http://localhost:8000`
   - Cek Status Kelulusan: `http://localhost:8000/cek_status.php`
   - Portal Admin/Panitia: `http://localhost:8000/admin/login.php`

*(Catatan: Aplikasi ini dilengkapi fitur Smart Fallback. Jika MySQL belum aktif di laptop Anda, sistem secara otomatis menginisialisasi SQLite lokal sehingga Anda bisa langsung menguji seluruh fitur pendaftaran, cetak bukti, dan login admin tanpa kendala!)*

---

### Cara 2: Menggunakan XAMPP (Apache & MySQL)
1. Salin seluruh isi folder ini ke folder `htdocs` XAMPP Anda:
   `C:\xampp\htdocs\spmb-sman1-astanajapura`
2. Buka **XAMPP Control Panel**, lalu klik **Start** pada modul **Apache** dan **MySQL**.
3. Buka browser dan buka `http://localhost/phpmyadmin`.
4. Buat database baru bernama: `spmb_sman1_astanajapura`.
5. Import file `database.sql` yang berada di dalam folder proyek ini.
6. Akses website melalui:
   - `http://localhost/spmb-sman1-astanajapura`

---

## 🔐 Kredensial Login Admin / Panitia

- **URL Login**: `http://localhost:8000/admin/login.php`
- **Username**: `admin`
- **Password**: `admin123`
