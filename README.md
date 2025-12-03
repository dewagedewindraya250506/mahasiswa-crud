1. Deskripsi Aplikasi
Aplikasi ini adalah implementasi back-end CRUD sederhana menggunakan PHP dan MySQL/MariaDB.
Entitas utama yang digunakan adalah Mahasiswa, dengan atribut:
• 	nama (teks pendek)
• 	nim (teks unik)
• 	prodi (pilihan dropdown)
• 	angkatan (numerik)
• 	foto_path (file upload, path disimpan di database)
• 	status (pilihan aktif/nonaktif)
Fungsi utama aplikasi:
• 	Menambah data mahasiswa (Create)
• 	Menampilkan daftar mahasiswa (Read)
• 	Mengubah data mahasiswa (Update)
• 	Menghapus data mahasiswa (Delete)
2. Spesifikasi Teknis
• 	Bahasa pemrograman: PHP 8.x (disarankan 8.4)
• 	Database: MySQL/MariaDB
• 	Driver: PDO (PHP Data Objects)
• 	Struktur folder:
/config        -> konfigurasi database & konstanta
/class         -> class Database, Mahasiswa, Utility
/public        -> file index.php, create.php, update.php, delete.php
/uploads       -> folder penyimpanan file foto mahasiswa
schema.sql     -> file skema database
README.md      -> dokumentasi
• 	Class utama:
• 	 → mengatur koneksi PDO ke MySQL
• 	 → logika CRUD untuk tabel mahasiswa
• 	 → helper untuk redirect, flash message, sanitasi input, dan upload file
3. Instruksi Menjalankan Aplikasi
1. 	Impor basis data
• 	Jalankan perintah berikut di MySQL/MariaDB:
CREATE DATABASE mahasiswa_crud;
USE mahasiswa_crud;

CREATE TABLE mahasiswa (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  nim VARCHAR(20) NOT NULL UNIQUE,
  prodi VARCHAR(50) NOT NULL,
  angkatan INT NOT NULL,
  foto_path VARCHAR(255),
  status ENUM('aktif','nonaktif') NOT NULL
);
• 	Atau gunakan file  yang sudah disediakan.


2. 	Konfigurasi koneksi database
• 	Edit file :
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'mahasiswa_crud');

define('BASE_URL', '/');
define('UPLOAD_DIR', __DIR__ . '/../public/uploads/');
define('UPLOAD_MAX_SIZE', 2 * 1024 * 1024);
define('UPLOAD_ALLOWED', ['image/jpeg', 'image/png']);

3. 	Menjalankan aplikasi
• 	Jalankan server PHP:
php -S localhost:8000 -t public
• 	Akses aplikasi di browser:
http://localhost:8000/index.php

4. Contoh Skenario Uji Singkat
- Tambah data mahasiswa
- Buka create.php, isi form dengan nama, NIM, prodi, angkatan, status, dan upload foto.
- Submit → data tersimpan di database, file foto tersimpan di folder uploads/.
- Tampilkan daftar mahasiswa
- Buka members.php atau index.php.
- Semua data mahasiswa ditampilkan dalam tabel dengan kolom aksi (Edit, Delete).
- Ubah data mahasiswa
- Klik tombol Edit pada salah satu mahasiswa.
- Form akan terisi data lama, lakukan perubahan lalu submit.
- Data di-update di database, file lama bisa diganti dengan file baru.
- Hapus data mahasiswa
- Klik tombol Delete pada salah satu mahasiswa.
- Konfirmasi penghapusan.
- Data dihapus dari database, file foto lama juga dihapus dari folder uploads/.

5. Repository
Proyek ini tersedia di GitHub:
👉 mahasiswa-crud
Repository berisi:
- Seluruh file kode aplikasi
- File schema.sql
- File README.md (dokumentasi)
- Struktur folder sesuai spesifikasi
- Riwayat commit pengembangan
