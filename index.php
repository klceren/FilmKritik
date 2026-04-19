<?php
session_start();
require_once 'functions.php';
if (!girisliMi()) { header('Location: giris.php'); exit; }
$filmler   = filmleriGetir();
$kullanici = oturumKullanici();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>FilmKritik</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
  <a href="index.php" class="nav-brand">FilmKritik</a>
  <div class="nav-center">
    <a href="index.php" class="nav-link">Filmler</a>
    <a href="favoriler.php" class="nav-link">Favorilerim</a>
  </div>
  <div class="nav-right">
    <div class="nav-avatar"><?= strtoupper(substr($kullanici, 0, 1)) ?></div>
    <span class="nav-username"><?= htmlspecialchars($kullanici) ?></span>
    <a href="cikis.php" class="btn-nav-exit">Çıkış</a>
  </div>
</nav>

<div class="page-header">
  <h1 class="page-title">Tüm <span>Filmler</span></h1>
</div>

<div class="container">
  <div class="film-grid">
    <?php foreach ($filmler as $film):
      $puan  = ortalamaPuan($film['id']);
      $favMi = favoriVarMi($kullanici, $film['id']);
    ?>
    <div class="film-card" onclick="window.location='film-detay.php?id=<?= $film['id'] ?>'">
      <div class="poster-wrap">
        <img src="<?= htmlspecialchars($film['poster']) ?>"
             alt="<?= htmlspecialchars($film['baslik']) ?>"
             onerror="this.src='https://via.placeholder.com/300x450/161616/c8a96e?text=Film'">
        <?php if ($puan > 0): ?>
        <div class="puan-badge">★ <?= $puan ?></div>
        <?php endif; ?>
        <form method="post" action="favori-toggle.php" onclick="event.stopPropagation()">
          <input type="hidden" name="film_id" value="<?= $film['id'] ?>">
          <input type="hidden" name="geri" value="index.php">
          <button type="submit" class="fav-btn <?= $favMi ? 'on' : '' ?>">
            <?= $favMi ? '♥' : '♡' ?>
          </button>
        </form>
      </div>
      <div class="card-info">
        <div class="card-title"><?= htmlspecialchars($film['baslik']) ?></div>
        <div class="card-meta"><?= $film['yil'] ?> · <?= htmlspecialchars($film['kategori']) ?></div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<footer>
  <span class="footer-brand">FilmKritik</span>
  <span class="footer-text">PHP & JSON · <?= date('Y') ?></span>
</footer>

</body>
</html>
