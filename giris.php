<?php
session_start();
require_once 'functions.php';
if (girisliMi()) { header('Location: index.php'); exit; }
$hata = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $k = girisYap(trim($_POST['kullanici_adi'] ?? ''), $_POST['sifre'] ?? '');
    if ($k) { $_SESSION['kullanici'] = $k['kullanici_adi']; header('Location: index.php'); exit; }
    else $hata = 'Kullanıcı adı veya şifre hatalı.';
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Giriş — FilmKritik</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="auth-page">
  <div class="auth-card">
    <div class="auth-title">FilmKritik</div>
    <div class="auth-sub">Giriş yap</div>

    <?php if ($hata): ?>
    <div class="alert-err"><?= htmlspecialchars($hata) ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="form-field">
        <label>Kullanıcı Adı</label>
        <input type="text" name="kullanici_adi" required autofocus
               value="<?= htmlspecialchars($_POST['kullanici_adi'] ?? '') ?>">
      </div>
      <div class="form-field">
        <label>Şifre</label>
        <input type="password" name="sifre" required>
      </div>
      <button type="submit" class="btn-primary">Giriş Yap</button>
    </form>

    <div class="auth-footer">
      Hesabın yok mu? <a href="kayit.php">Kayıt ol</a>
    </div>
  </div>
</div>
</body>
</html>
