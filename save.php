<?php
require_once __DIR__ . '/inc/config.php';

// basic validation
$nama = trim($_POST['nama'] ?? '');
$nim = trim($_POST['nim'] ?? '');
$prodi = trim($_POST['prodi'] ?? '');
$angkatan = $_POST['angkatan'] ?? '';
$status = $_POST['status'] ?? 'aktif';

// prefill in session in case of error
$_SESSION['prefill'] = [
    'nama' => $nama,
    'nim' => $nim,
    'prodi' => $prodi,
    'angkatan' => $angkatan,
    'status' => $status
];

// validate required
if ($nama === '' || $nim === '' || $prodi === '' || $angkatan === '') {
    Utility::flash('error', 'Semua field bertanda wajib harus diisi.');
    Utility::redirect('create.php');
}

// validate numeric angkatan
if (!is_numeric($angkatan) || (int)$angkatan <= 0) {
    Utility::flash('error', 'Angkatan harus berupa angka positif.');
    Utility::redirect('create.php');
}

// validate status
if (!in_array($status, ['aktif','nonaktif'])) {
    Utility::flash('error', 'Status tidak valid.');
    Utility::redirect('create.php');
}

// handle upload
$uploadResult = Utility::handleUpload($_FILES['foto'] ?? []);
if (!$uploadResult['success']) {
    Utility::flash('error', $uploadResult['error']);
    Utility::redirect('create.php');
}

// prepare data
$data = [
    'nama' => $nama,
    'nim' => $nim,
    'prodi' => $prodi,
    'angkatan' => (int)$angkatan,
    'foto_path' => $uploadResult['path'],
    'status' => $status
];

$m = new Mahasiswa();
try {
    $ok = $m->create($data);
    if ($ok) {
        unset($_SESSION['prefill']);
        Utility::flash('success', 'Mahasiswa berhasil ditambahkan.');
        Utility::redirect('members.php');
    } else {
        Utility::flash('error', 'Gagal menyimpan data.');
        Utility::redirect('create.php');
    }
} catch (PDOException $e) {
    // possible duplicate nim -> unique constraint
    Utility::flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
    Utility::redirect('create.php');
}