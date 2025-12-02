<?php
require_once __DIR__ . '/inc/config.php';

// if prefill or errors via flash, handle here (simple approach)
$prefill = $_SESSION['prefill'] ?? [];
unset($_SESSION['prefill']);
$error = Utility::flash('error');
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Tambah Mahasiswa</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
</head>
<body>
  <h1>Tambah Mahasiswa</h1>
  <nav><a href="<?= BASE_URL ?>members.php">Kembali ke list</a></nav>

  <?php if ($error): ?>
    <p class="msg error"><?= Utility::sanitize($error) ?></p>
  <?php endif; ?>

  <form action="<?= BASE_URL ?>save.php" method="post" enctype="multipart/form-data">
    <label>Nama (required)</label><br>
    <input type="text" name="nama" value="<?= Utility::sanitize($prefill['nama'] ?? '') ?>" required><br>

    <label>NIM (required)</label><br>
    <input type="text" name="nim" value="<?= Utility::sanitize($prefill['nim'] ?? '') ?>" required><br>

    <label>Prodi (required)</label><br>
    <input type="text" name="prodi" value="<?= Utility::sanitize($prefill['prodi'] ?? '') ?>" required><br>

    <label>Angkatan (required - numeric)</label><br>
    <input type="number" name="angkatan" value="<?= Utility::sanitize($prefill['angkatan'] ?? '') ?>" required><br>

    <label>Foto (jpg/png, &lt;2MB)</label><br>
    <input type="file" name="foto" accept=".jpg,.jpeg,.png"><br>

    <label>Status</label><br>
    <select name="status" required>
      <option value="aktif" <?= (isset($prefill['status']) && $prefill['status'] === 'aktif') ? 'selected' : '' ?>>Aktif</option>
      <option value="nonaktif" <?= (isset($prefill['status']) && $prefill['status'] === 'nonaktif') ? 'selected' : '' ?>>Nonaktif</option>
    </select><br><br>

    <button type="submit">Simpan</button>
  </form>
</body>
</html>