<?php
require_once __DIR__ . '/inc/config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$m = new Mahasiswa();
$row = $m->getById($id);
if (!$row) {
    Utility::flash('error', 'Data tidak ditemukan.');
    Utility::redirect('members.php');
}

$error = Utility::flash('error');
$prefill = $_SESSION['prefill'] ?? [];
unset($_SESSION['prefill']);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Mahasiswa</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
</head>
<body>
  <h1>Edit Mahasiswa</h1>
  <nav><a href="<?= BASE_URL ?>members.php">Kembali ke list</a></nav>

  <?php if ($error): ?>
    <p class="msg error"><?= Utility::sanitize($error) ?></p>
  <?php endif; ?>

  <form action="<?= BASE_URL ?>update.php?id=<?= $row['id'] ?>" method="post" enctype="multipart/form-data">
    <label>Nama</label><br>
    <input type="text" name="nama" value="<?= Utility::sanitize($prefill['nama'] ?? $row['nama']) ?>" required><br>

    <label>NIM</label><br>
    <input type="text" name="nim" value="<?= Utility::sanitize($prefill['nim'] ?? $row['nim']) ?>" required><br>

    <label>Prodi</label><br>
    <input type="text" name="prodi" value="<?= Utility::sanitize($prefill['prodi'] ?? $row['prodi']) ?>" required><br>

    <label>Angkatan</label><br>
    <input type="number" name="angkatan" value="<?= Utility::sanitize($prefill['angkatan'] ?? $row['angkatan']) ?>" required><br>

    <label>Foto (biarkan kosong untuk mempertahankan)</label><br>
    <?php if ($row['foto_path']): ?>
      <img src="<?= Utility::sanitize($row['foto_path']) ?>" alt="" style="height:80px;"><br>
    <?php endif; ?>
    <input type="file" name="foto" accept=".jpg,.jpeg,.png"><br>

    <label>Status</label><br>
    <select name="status" required>
      <option value="aktif" <?= (($prefill['status'] ?? $row['status']) === 'aktif') ? 'selected' : '' ?>>Aktif</option>
      <option value="nonaktif" <?= (($prefill['status'] ?? $row['status']) === 'nonaktif') ? 'selected' : '' ?>>Nonaktif</option>
    </select><br><br>

    <button type="submit">Update</button>
  </form>
</body>
</html>