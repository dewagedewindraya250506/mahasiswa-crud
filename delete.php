<?php
require_once __DIR__ . '/inc/config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$m = new Mahasiswa();
$existing = $m->getById($id);
if (!$existing) {
    Utility::flash('error', 'Data tidak ditemukan.');
    Utility::redirect('members.php');
}

// Try delete DB record, then try delete file if exists
try {
    $ok = $m->delete($id);
    if ($ok) {
        // delete photo file if exists
        if ($existing['foto_path']) {
            $file = __DIR__ . '/' . $existing['foto_path'];
            if (file_exists($file)) {
                @unlink($file);
            }
        }
        Utility::flash('success', 'Data berhasil dihapus.');
    } else {
        Utility::flash('error', 'Gagal menghapus data.');
    }
} catch (PDOException $e) {
    Utility::flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
}

Utility::redirect('members.php');