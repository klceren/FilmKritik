<?php
session_start();
require_once 'functions.php';
if (!girisliMi()) { header('Location: giris.php'); exit; }
$film_id = (int)($_POST['film_id'] ?? 0);
$geri    = $_POST['geri'] ?? 'index.php';
if ($film_id && filmBul($film_id)) {
    favoriToggle(oturumKullanici(), $film_id);
}
header('Location: ' . $geri);
exit;
