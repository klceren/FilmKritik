<?php
session_start();
require_once 'functions.php';
if (girisliMi()) { header('Location: index.php'); exit; }
$hata = $basari = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ku  = trim($_POST['kullanici_adi'] ?? '');
    $em  = trim($_POST['email'] ?? '');
    $si  = $_POST['sifre'] ?? '';
    $si2 = $_POST['sifre2'] ?? '';
    if (strlen($ku) < 3)                             $hata = 'Kullanıcı adı en az 3 karakter olmalı.';
    elseif (!filter_var($em, FILTER_VALIDATE_EMAIL)) $hata = 'Geçerli bir e-posta girin.';
    elseif (strlen($si) < 6)                         $hata = 'Şifre en az 6 karakter olmalı.';
    elseif ($si !== $si2)                            $hata = 'Şifreler eşleşmiyor.';
    elseif (!kullaniciKaydet($ku, $em, $si))         $hata = 'Bu kullanıcı adı zaten alınmış.';
    else $basari = 'Kayıt başarılı!';
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Kayıt Ol — FilmKritik</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="auth-page">
  <div class="auth-card">
    <div class="auth-title">FilmKritik</div>
    <div class="auth-sub">Hesap oluştur</div>

    <?php if ($hata): ?>
    <div class="alert-err"><?= htmlspecialchars($hata) ?></div>
    <?php endif; ?>

    <?php if ($basari): ?>
    <div class="alert-ok">
      Kayıt başarılı! <a href="giris.php" style="color:var(--accent)">Giriş yap →</a>
    </div>
    <?php endif; ?>

    <form method="post">
      <div class="form-field">
        <label>Kullanıcı Adı</label>
        <input type="text" name="kullanici_adi" required
               value="<?= htmlspecialchars($_POST['kullanici_adi'] ?? '') ?>">
      </div>
      <div class="form-field">
        <label>E-posta</label>
        <input type="email" name="email" required
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
      </div>
      <div class="form-field">
        <label>Şifre</label>
        <input type="password" name="sifre" required>
      </div>
      <div class="form-field">
        <label>Şifre Tekrar</label>
        <input type="password" name="sifre2" required>
      </div>
      <button type="submit" class="btn-primary">Kayıt Ol</button>
    </form>

    <div class="auth-footer">
      Zaten hesabın var mı? <a href="giris.php">Giriş yap</a>
    </div>
  </div>
</div>
</body>
</html>
