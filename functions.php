<?php
define('VERI_DIR', __DIR__ . '/veri/');

function jsonOku($dosya) {
    $yol = VERI_DIR . $dosya;
    if (!file_exists($yol)) return [];
    return json_decode(file_get_contents($yol), true) ?? [];
}

function jsonYaz($dosya, $veri) {
    file_put_contents(VERI_DIR . $dosya, json_encode($veri, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function kullaniciBul($kullanici_adi) {
    foreach (jsonOku('kullanicilar.json') as $k)
        if ($k['kullanici_adi'] === $kullanici_adi) return $k;
    return null;
}

function kullaniciKaydet($kullanici_adi, $email, $sifre) {
    if (kullaniciBul($kullanici_adi)) return false;
    $liste = jsonOku('kullanicilar.json');
    $liste[] = [
        'id'            => time(),
        'kullanici_adi' => $kullanici_adi,
        'email'         => $email,
        'sifre'         => password_hash($sifre, PASSWORD_DEFAULT),
        'kayit_tarihi'  => date('Y-m-d')
    ];
    jsonYaz('kullanicilar.json', $liste);
    return true;
}

function girisYap($kullanici_adi, $sifre) {
    $k = kullaniciBul($kullanici_adi);
    if ($k && password_verify($sifre, $k['sifre'])) return $k;
    return false;
}

function filmleriGetir() {
    return jsonOku('filmler.json');
}

function filmBul($id) {
    foreach (jsonOku('filmler.json') as $f)
        if ((int)$f['id'] === (int)$id) return $f;
    return null;
}

function yorumlariGetir($film_id) {
    return array_values(array_filter(
        jsonOku('yorumlar.json'),
        fn($y) => (int)$y['film_id'] === (int)$film_id
    ));
}

function ortalamaPuan($film_id) {
    $yorumlar = yorumlariGetir($film_id);
    if (empty($yorumlar)) return 0;
    return round(array_sum(array_column($yorumlar, 'puan')) / count($yorumlar), 1);
}

function favorileriGetir($kullanici) {
    return array_values(array_filter(
        jsonOku('favoriler.json'),
        fn($f) => $f['kullanici'] === $kullanici
    ));
}

function favoriVarMi($kullanici, $film_id) {
    foreach (jsonOku('favoriler.json') as $f)
        if ($f['kullanici'] === $kullanici && (int)$f['film_id'] === (int)$film_id) return true;
    return false;
}

function favoriToggle($kullanici, $film_id) {
    $liste = jsonOku('favoriler.json');
    foreach ($liste as $i => $f) {
        if ($f['kullanici'] === $kullanici && (int)$f['film_id'] === (int)$film_id) {
            array_splice($liste, $i, 1);
            jsonYaz('favoriler.json', $liste);
            return false;
        }
    }
    $liste[] = ['kullanici' => $kullanici, 'film_id' => (int)$film_id];
    jsonYaz('favoriler.json', $liste);
    return true;
}

function girisliMi() { return isset($_SESSION['kullanici']); }
function oturumKullanici() { return $_SESSION['kullanici'] ?? null; }
?>
