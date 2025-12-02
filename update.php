<?php
require_once __DIR__ . '/inc/config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$nama = trim($_POST['nama'] ?? '');
$nim = trim($_POST['nim'] ?? '');
$prodi = trim($_POST['prodi'] ?? '');
$angkatan = $_POST['angkatan'] ?? '';
$status = $_POST['status'] ?? 'aktif';

// prefill
$_SESSION['prefill'] = [
    'nama' => $nama,
    'nim' => $nim,
    'prodi' => $prodi,
    'angkatan' => $angkatan,
    'status' => $status
];

$m = new Mahasiswa();
$existing = $m->getById($id);
if (!$existing) {
    Utility::flash('error', 'Data tidak ditemukan.');
    Utility::redirect('members.php');
}

// basic validation
if ($nama === '' || $nim === '' || $prodi === '' || $angkatan === '') {
    Utility::flash('error', 'Semua field wajib harus diisi.');
    Utility::redirect('edit.php?id=' . $id);
}

if (!is_numeric($angkatan) || (int)$angkatan <= 0) {
    Utility::flash('error', 'Angkatan harus angka positif.');
    Utility::redirect('edit.php?id=' . $id);
}

if (!in_array($status, ['aktif','nonaktif'])) {
    Utility::flash('error', 'Status tidak valid.');
    Utility::redirect('edit.php?id=' . $id);
}

// handle upload (if no new upload, keep old path)
$uploadResult = Utility::handleUpload($_FILES['foto'] ?? [], $existing['foto_path']);
if (!$uploadResult['success']) {
    Utility::flash('error', $uploadResult['error']);
    Utility::redirect('edit.php?id=' . $id);
}

$data = [
    'nama' => $nama,
    'nim' => $nim,
    'prodi' => $prodi,
    'angkatan' => (int)$angkatan,
    'foto_path' => $uploadResult['path'],
    'status' => $status
];

try {
    $ok = $m->update($id, $data);
    if ($ok) {
        unset($_SESSION['prefill']);
        Utility::flash('success', 'Data berhasil diupdate.');
        Utility::redirect('members.php');
    } else {
        Utility::flash('error', 'Gagal mengupdate data.');
        Utility::redirect('edit.php?id=' . $id);
    }
} catch (PDOException $e) {
    Utility::flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
    Utility::redirect('edit.php?id=' . $id);
}