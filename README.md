# Brillian Ghulam Portfolio

Personal portfolio dan interactive CV berbasis Laravel, Blade, Tailwind CSS, Alpine.js, dan PostgreSQL.

Website publik: [https://brillianghulam20.github.io](https://brillianghulam20.github.io)

## Menjalankan di Windows

Klik dua kali `start-local.bat`. Script akan memasang dependency bila diperlukan, menjalankan migration, membuka Vite, menjalankan Laravel, dan membuka browser.

- Website lokal: `http://127.0.0.1:8000`
- Admin CMS: `http://127.0.0.1:8000/admin/login`

Perubahan konten dilakukan melalui CMS. Perubahan desain atau program dilakukan pada source Laravel di repository ini.

## Publikasi

Setelah perubahan lokal selesai:

1. Pastikan website lokal dapat dibuka dan kontennya benar.
2. Klik dua kali `publish-pages.bat`.
3. Script membangun asset production, mengekspor seluruh halaman publik, menyalin media/CV, membuat commit, dan push ke repository GitHub Pages.
4. Tunggu sekitar 1-3 menit lalu buka `https://brillianghulam20.github.io`.

Versi GitHub Pages bersifat statis. CMS hanya berjalan di lokal, tetapi semua perubahan konten yang telah diekspor akan tampil pada website publik.

## Pengembangan Manual

```bash
composer install
npm install
php artisan migrate --force
php artisan portfolio:install
composer run dev
```

Jalankan test hanya jika `.env.testing` sudah dikonfigurasi ke database test terpisah. Test menggunakan refresh database dan tidak boleh diarahkan ke database konten utama.

```bash
php artisan test --compact
```
