# FilmKritik - Web Programlama Projesi

Bu proje, PHP ve JSON kullanılarak geliştirilmiş, veritabanı kurulumu gerektirmeyen taşınabilir bir film rehberi ve favori listesi uygulamasıdır. İnönü Üniversitesi Bilgisayar Programcılığı dersi kapsamında "Öğrenci Projesi" olarak hazırlanmıştır.

## 🚀 Proje Özellikleri
* **Üyelik Sistemi:** Kullanıcı kayıt olma ve giriş yapma modülleri mevcuttur.
* **Film Listeleme:** `veri/filmler.json` dosyasındaki verileri dinamik olarak ana sayfada listeler.
* **Film Detayları:** Seçilen filmin özetini, kategorisini ve eklenme bilgilerini gösterir.
* **Favori Sistemi:** Kullanıcılar beğendikleri filmleri favorilerine ekleyebilir ve "Favorilerim" sayfasında listeleyebilir.
* **JSON Tabanlı Veri:** SQL veritabanı kurulumu zahmeti olmadan, tüm veriler `.json` dosyaları üzerinden yönetilir.

## 📂 Klasör Yapısı
```text
FilmKritik/
├── css/
│   └── style.css          # Projenin tüm görsel tasarımı
├── veri/
│   ├── filmler.json       # Film veritabanı
│   ├── kullanicilar.json  # Üye bilgileri
│   └── favoriler.json     # Kullanıcı-film favori eşleşmeleri
├── functions.php          # JSON okuma/yazma ve oturum kontrolü fonksiyonları
├── index.php              # Ana sayfa (Film kartları)
├── film-detay.php         # Film detay sayfası
├── favoriler.php          # Kullanıcının favori listesi
├── favori-toggle.php      # Favoriye ekleme/çıkarma işlemi (Arka plan)
├── giris.php              # Giriş ekranı
├── kayit.php              # Kayıt ekranı
└── cikis.php              # Oturumu sonlandırma işlemi