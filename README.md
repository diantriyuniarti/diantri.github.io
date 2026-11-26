# Aplikasi Web SPMB SMAN 1 Astanajapura

Sistem Informasi Penerimaan Peserta Didik Baru (SPMB) SMA Negeri 1 Astanajapura  
Kabupaten Cirebon, Jawa Barat  
Pengembang: Dian Tri Yuniarti

---

## Deskripsi Sistem

Aplikasi web untuk mendukung alur pendaftaran siswa baru secara daring pada SMA Negeri 1 Astanajapura. Sistem ini mencakup portal pendaftaran bagi calon siswa, pencetakan bukti pendaftaran berformat kop dinas pendidikan resmi, pelacakan status berkas seleksi secara mandiri, dan dashboard verifikasi bagi panitia sekolah.

---

## Fitur Utama

1. Portal Calon Siswa
   * Profil sekolah, peminatan program studi (IPA, IPS, Bahasa), dan linimasa SPMB
   * Formulir pendaftaran online interaktif dengan penanganan validasi AJAX
   * Nomor pendaftaran resmi otomatis dan pencetakan bukti registrasi siap cetak

2. Cek Status Seleksi
   * Pelacakan mandiri status seleksi (Menunggu Verifikasi, Berkas Terverifikasi, Lulus Seleksi, Tidak Lulus) menggunakan Nomor Pendaftaran atau NISN

3. Portal Panitia dan Administrator
   * Autentikasi panitia dengan enkripsi password (bcrypt)
   * Statistik pendaftaran per jurusan dan per status berkas
   * Pencarian dan penyaringan data pendaftar
   * Manajemen perubahan status pendaftar dan catatan panitia

---

## Arsitektur Teknologi

* Bahasa Pemrograman: PHP
* Basis Data: MySQL / MariaDB (skema `database.sql`) dan SQLite (`database.sqlite`)
* Styling & Interaktivitas: Tailwind CSS, Vanilla JavaScript AJAX

---

## Panduan Menjalankan

1. Masuk ke direktori proyek:
   ```bash
   cd spmb-sman1-astanajapura
   ```

2. Jalankan server lokal PHP:
   ```bash
   php -S localhost:8000
   ```

3. Akses melalui browser:
   * Portal Calon Siswa: `http://localhost:8000`
   * Cek Status Kelulusan: `http://localhost:8000/cek_status.php`
   * Portal Panitia / Admin: `http://localhost:8000/admin/login.php`
