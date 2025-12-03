<?php
// class/Utility.php

require_once __DIR__ . '/../config/config.php'; // Pastikan semua konstanta tersedia

class Utility {
    public static function redirect(string $url): void {
        // support BASE_URL (may be kosong)
        $base = defined('BASE_URL') ? BASE_URL : '';
        header('Location: ' . rtrim($base, '/') . '/' . ltrim($url, '/'));
        exit;
    }

    public static function flash(string $key, ?string $message = null): ?string {
        if (!isset($_SESSION)) {
            session_start(); // pastikan session aktif
        }

        if ($message === null) {
            // get and clear
            if (isset($_SESSION['flash'][$key])) {
                $msg = $_SESSION['flash'][$key];
                unset($_SESSION['flash'][$key]);
                return $msg;
            }
            return null;
        }

        $_SESSION['flash'][$key] = $message;
        return null;
    }

    public static function sanitize($value): string {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }

    // file upload helper: returns ['success' => bool, 'path' => ..., 'error' => ...]
    public static function handleUpload(array $file, ?string $oldPath = null): array {
        // Validasi konstanta
        $maxSize = defined('UPLOAD_MAX_SIZE') ? UPLOAD_MAX_SIZE : 2 * 1024 * 1024;
        $allowedTypes = defined('UPLOAD_ALLOWED') ? UPLOAD_ALLOWED : ['image/jpeg', 'image/png'];
        $uploadDir = defined('UPLOAD_DIR') ? UPLOAD_DIR : __DIR__ . '/../public/uploads/';

        if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return ['success' => true, 'path' => $oldPath ?? null, 'error' => null];
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'Upload error code: ' . $file['error']];
        }

        if ($file['size'] > $maxSize) {
            return ['success' => false, 'error' => 'File terlalu besar (maks 2MB).'];
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, $allowedTypes)) {
            return ['success' => false, 'error' => 'Tipe file tidak diperbolehkan (hanya JPG/PNG).'];
        }

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $safeName = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
        $dest = rtrim($uploadDir, '/') . '/' . $safeName;

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            return ['success' => false, 'error' => 'Gagal memindahkan file.'];
        }

        // Hapus file lama jika ada
        if ($oldPath) {
            $oldFile = rtrim($uploadDir, '/') . '/' . basename($oldPath);
            if (file_exists($oldFile)) {
                @unlink($oldFile);
            }
        }

        // Simpan path relatif untuk database
        $relative = 'uploads/' . $safeName;
        return ['success' => true, 'path' => $relative, 'error' => null];
    }
}

