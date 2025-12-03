<?php
// Aktifkan error reporting saat pengembangan
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Konfigurasi koneksi database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'mahasiswa_crud');

// Autoload class dari folder /class
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/../class/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Menu navigasi sederhana
$NAV_PAGES = [
    ['title' => 'Beranda',   'url' => 'index.php'],
    ['title' => 'Mahasiswa', 'url' => 'members.php'],
    ['title' => 'Tambah',    'url' => 'create.php']
];