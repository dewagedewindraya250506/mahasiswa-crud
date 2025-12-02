<?php
// class/Utility.php

class Utility {
    public static function redirect(string $url) {
        // support BASE_URL (may be empty)
        header('Location: ' . BASE_URL . $url);
        exit;
    }

    public static function flash(string $key, ?string $message = null) {
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
    }

    public static function sanitize($value) {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }

    // file upload helper: returns ['success' => bool, 'path' => ..., 'error' => ...]
    public static function handleUpload(array $file, ?string $oldPath = null): array {
        if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            // no new file uploaded
            return ['success' => true, 'path' => $oldPath ?? null, 'error' => null];
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'Upload error code: ' . $file['error']];
        }

        if ($file['size'] > UPLOAD_MAX_SIZE) {
            return ['success' => false, 'error' => 'File terlalu besar (maks 2MB).'];
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, UPLOAD_ALLOWED)) {
            return ['success' => false, 'error' => 'Tipe file tidak diperbolehkan (hanya JPG/PNG).'];
        }

        // memastikan upload dir ada
        if (!is_dir(UPLOAD_DIR)) {
            mkdir(UPLOAD_DIR, 0755, true);
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $safeName = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
        $dest = UPLOAD_DIR . $safeName;

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            return ['success' => false, 'error' => 'Gagal memindahkan file.'];
        }

        // optional: hapus file lama
        if ($oldPath) {
            $oldFull = realpath(UPLOAD_DIR . '..') ? $oldPath : null; // noop - we will attempt delete based on stored path
            // Try best-effort delete: oldPath stores relative 'uploads/...' or basename
            $possible = rtrim(UPLOAD_DIR, '/') . '/' . basename($oldPath);
            if (file_exists($possible)) {
                @unlink($possible);
            }
        }

        // return relative path to store in DB (so project portable)
        $relative = 'uploads/' . $safeName;
        return ['success' => true, 'path' => $relative, 'error' => null];
    }
}