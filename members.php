<?php
require_once __DIR__ . '/inc/config.php';

$mahasiswa = new Mahasiswa();
$rows = $mahasiswa->getAll();

// flash message example
$msg = Utility::flash('success');
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Daftar Mahasiswa</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
</head>
<body>
  <header>
    <h1>Daftar Mahasiswa</h1>
    <nav>
      <a href="<?= BASE_URL ?>members.php">List</a> |
      <a href="<?= BASE_URL ?>create.php">Tambah Baru</a>
    </nav>
  </header>

  <?php if ($msg): ?>
    <p class="msg success"><?= Utility::sanitize($msg) ?></p>
  <?php endif; ?>

  <table border="1" cellpadding="8" cellspacing="0">
    <thead>
      <tr>
        <th>No</th>
        <th>Foto</th>
        <th>Nama</th>
        <th>NIM</th>
        <th>Prodi</th>
        <th>Angkatan</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
    <?php if (empty($rows)): ?>
      <tr><td colspan="8">Belum ada data mahasiswa.</td></tr>
    <?php else: ?>
      <?php $no = 1; foreach ($rows as $r): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td>
            <?php if ($r['foto_path']): ?>
              <img src="<?= Utility::sanitize($r['foto_path']) ?>" alt="" style="height:60px;">
            <?php else: ?>
              -
            <?php endif; ?>
          </td>
          <td><?= Utility::sanitize($r['nama']) ?></td>
          <td><?= Utility::sanitize($r['nim']) ?></td>
          <td><?= Utility::sanitize($r['prodi']) ?></td>
          <td><?= Utility::sanitize($r['angkatan']) ?></td>
          <td><?= Utility::sanitize($r['status']) ?></td>
          <td>
            <a href="<?= BASE_URL ?>edit.php?id=<?= $r['id'] ?>">Edit</a> |
            <a href="<?= BASE_URL ?>delete.php?id=<?= $r['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
  </table>
</body>
</html>