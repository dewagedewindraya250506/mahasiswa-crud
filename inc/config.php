<?php
// inc/config.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// base url (sesuaikan jika menjalankan di subfolder; bila di root http://localhost:8000/ gunakan '')
define('BASE_URL', ''); // contoh: '/mahasiswa-crud/' jika di subfolder

// Database credentials - sesuaikan sebelum menjalankan
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'crud_mahasiswa');
define('DB_USER', 'root');
define('DB_PASS', ''); // isi password mysql mu

// upload config
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('UPLOAD_MAX_SIZE', 2 * 1024 * 1024); // 2 MB
define('UPLOAD_ALLOWED', ['image/jpeg','image/png','image/jpg']);

// autoload classes from /class
spl_autoload_register(function ($class_name) {
    $path = __DIR__ . '/../class/' . $class_name . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});
