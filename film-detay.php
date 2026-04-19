<?php
session_start();
require_once 'functions.php';
if (!girisliMi()) { header('Location: giris.php'); exit; }
$id   = (int)($_GET['id'] ?? 0);
$film = filmBul($id);
if (!$film) { header('Location: index.php'); exit; }
$kullanici = oturumKullanici();
$yorumlar  = yorumlariGetir($id);
$puan_ort  = ortalamaPuan($id);
$favMi     = favoriVarMi($kullanici, $id);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title><?= htmlspecialchars($film['baslik']) ?> — FilmKritik</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
  <a href="index.php" class="nav-brand">FilmKritik</a>
  <div class="nav-center">
    <a href="index.php" class="nav-link">← Filmler</a>
    <a href="favoriler.php" class="nav-link">Favorilerim</a>
  </div>
  <div class="nav-right">
    <div class="nav-avatar"><?= strtoupper(substr($kullanici, 0, 1)) ?></div>
    <span class="nav-username"><?= htmlspecialchars($kullanici) ?></span>
    <a href="cikis.php" class="btn-nav-exit">Çıkış</a>
  </div>
</nav>

<div class="detail-page">
  <div class="detail-hero">
    <img class="detail-poster"
         src="<?= htmlspecialchars($film['poster']) ?>"
         alt="<?= htmlspecialchars($film['baslik']) ?>"
         onerror="this.src='https://via.placeholder.com/190x285/161616/c8a96e?text=Film'">

    <div class="detail-info">
      <p class="detail-kat"><?= htmlspecialchars($film['kategori']) ?></p>
      <h1 class="detail-title"><?= htmlspecialchars($film['baslik']) ?></h1>

      <div class="detail-chips">
        <span class="chip">📅 <?= $film['yil'] ?></span>
        <span class="chip">🎬 <?= htmlspecialchars($film['yonetmen']) ?></span>
        <span class="chip">⏱ <?= htmlspecialchars($film['sure']) ?></span>
      </div>

      <div class="detail-rating">
        <div class="stars-row">
          <?php for ($i = 1; $i <= 5; $i++): ?>
          <span class="star <?= $i <= round($puan_ort) ? 'on' : '' ?>">★</span>
          <?php endfor; ?>
        </div>
        <?php if ($puan_ort > 0): ?>
          <span class="rating-big"><?= $puan_ort ?></span>
          <span class="rating-info"><?= count($yorumlar) ?> yorum</span>
        <?php else: ?>
          <span class="rating-info">Henüz puanlanmadı</span>
        <?php endif; ?>
      </div>

      <p class="detail-desc"><?= nl2br(htmlspecialchars($film['aciklama'])) ?></p>

      <form method="post" action="favori-toggle.php">
        <input type="hidden" name="film_id" value="<?= $film['id'] ?>">
        <input type="hidden" name="geri" value="film-detay.php?id=<?= $film['id'] ?>">
        <button type="submit" class="btn-fav <?= $favMi ? 'on' : '' ?>">
          <?= $favMi ? '♥ Favorilerimde' : '♡ Favorilere Ekle' ?>
        </button>
      </form>

      <p class="detail-ekleyen">
        Ekleyen: <?= htmlspecialchars($film['ekleyen']) ?> · <?= $film['eklenme_tarihi'] ?>
      </p>
    </div>
  </div>

  <?php if (!empty($yorumlar)): ?>
  <div class="reviews-wrap">
    <h2 class="reviews-head">Yorumlar</h2>
    <div class="review-list">
      <?php foreach (array_reverse($yorumlar) as $y): ?>
      <div class="review-card">
        <div class="review-top">
          <div class="review-user">
            <div class="r-avatar"><?= strtoupper(substr($y['kullanici'], 0, 1)) ?></div>
            <span class="r-name"><?= htmlspecialchars($y['kullanici']) ?></span>
          </div>
          <span class="r-date"><?= $y['tarih'] ?></span>
        </div>
        <div class="r-stars">
          <?= str_repeat('★', $y['puan']) ?><?= str_repeat('☆', 5 - $y['puan']) ?>
        </div>
        <p class="r-text"><?= nl2br(htmlspecialchars($y['yorum'])) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>
</div>

<footer>
  <span class="footer-brand">FilmKritik</span>
  <span class="footer-text">PHP & JSON · <?= date('Y') ?></span>
</footer>

</body>
</html>
