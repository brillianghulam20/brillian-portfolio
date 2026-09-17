# Tutorial Menjalankan dan Memublikasikan Portfolio

Panduan ini ditujukan untuk Windows dan project yang berada di `D:\Web Portofolio`.

## Struktur Repository

Project menggunakan dua repository GitHub yang berbeda:

- Source Laravel dan CMS: `https://github.com/brillianghulam20/brillian-portfolio`
- Website publik GitHub Pages: `https://github.com/brillianghulam20/brillianghulam20.github.io`

Repository source menyimpan kode Laravel. Repository GitHub Pages menyimpan hasil ekspor HTML, CSS, JavaScript, gambar, dan CV. Jangan menyalin `.env` ke GitHub karena file tersebut berisi credential database.

## 1. Menjalankan Website di Lokal

### Cara termudah

1. Buka File Explorer.
2. Masuk ke folder `D:\Web Portofolio`.
3. Klik dua kali `start-local.bat`.
4. Tunggu proses `npm run build` selesai.
5. Jangan tutup jendela terminal selama website digunakan.
6. Buka `http://127.0.0.1:8000`.

Alamat penting:

- Website: `http://127.0.0.1:8000`
- Admin CMS: `http://127.0.0.1:8000/admin/login`
- Projects: `http://127.0.0.1:8000/projects`
- Contact: `http://127.0.0.1:8000/contact`

### Login admin lokal

Gunakan nilai `ADMIN_EMAIL` dan `ADMIN_PASSWORD` yang tersimpan dalam file `.env`. Jangan menaruh password tersebut di source code atau repository publik.

### Menjalankan secara manual

Buka Git Bash atau terminal pada folder project, kemudian jalankan:

```bash
composer install
npm install
php artisan optimize:clear
php artisan migrate --force
php artisan portfolio:install
php artisan storage:link
npm run build
php artisan serve --host=127.0.0.1 --port=8000
```

## 2. Mengubah Konten

### Mengubah melalui CMS

1. Jalankan website lokal.
2. Buka `http://127.0.0.1:8000/admin/login`.
3. Login sebagai administrator.
4. Gunakan menu Profile untuk nama, title, bio, kontak, foto, dan CV.
5. Gunakan Experience untuk pengalaman kerja.
6. Gunakan Education untuk pendidikan.
7. Gunakan Skills untuk keahlian.
8. Gunakan Certificates untuk sertifikat.
9. Gunakan Project Categories untuk kategori project.
10. Gunakan Projects untuk case study, feature, technology, architecture, dan gallery.

Project hanya tampil di website publik jika `Publishing status` diatur menjadi `published`.

### Menambahkan gambar hasil project

1. Buka **Admin CMS > Projects**.
2. Pilih **Edit** pada project yang ingin diperbarui.
3. Buka bagian **Technical & Media**.
4. Upload **Thumbnail / gambar utama** untuk gambar pada kartu project.
5. Upload **Architecture image** jika tersedia diagram arsitektur.
6. Upload beberapa **Gallery images** untuk screenshot halaman detail project.
7. Klik **Simpan project**.

Rekomendasi thumbnail:

- Rasio landscape `16:9`.
- Ukuran minimal `1200×675 px`.
- Format PNG, JPG/JPEG, atau WebP.
- Maksimal 4 MB per gambar.
- Gunakan data dummy atau screenshot yang sudah dianonimkan.
- Jangan menampilkan password, API token, domain internal, data karyawan, harga rahasia, atau data production.

Jika thumbnail belum diunggah, kartu memakai gambar pertama dari gallery. Jika keduanya belum ada, kartu menggunakan visual fallback bawaan.

## 3. Akses dari PC, Laptop, HP, Android, iPhone, iPad, dan Tablet

Mode ini membuat komputer utama menjadi server pada jaringan lokal. Komputer utama harus tetap menyala dan jendela terminal server tidak boleh ditutup.

### Persiapan pertama kali

1. Hubungkan komputer utama dan perangkat lain ke Wi-Fi atau LAN yang sama.
2. Pada Windows, buka **Settings > Network & internet > Wi-Fi/Ethernet > Network profile type**.
3. Pilih profile **Private network**. Jangan gunakan mode ini pada Wi-Fi publik.
4. Klik kanan `setup-network-firewall.bat` lalu pilih **Run as administrator**.
5. Setujui dialog User Account Control.
6. Pastikan muncul pesan bahwa firewall berhasil dikonfigurasi.

Aturan firewall hanya membuka TCP port `8000` untuk perangkat pada local subnet dan profile jaringan Private.

### Menjalankan server jaringan

1. Klik dua kali `start-network.bat`.
2. Tunggu migration dan frontend build selesai.
3. Terminal akan menampilkan alamat seperti:

```text
Website perangkat lain: http://192.168.1.10:8000
Admin perangkat lain:   http://192.168.1.10:8000/admin/login
```

4. Ketik alamat tersebut di Chrome, Safari, Firefox, atau browser lain pada HP/tablet/laptop teman.
5. Jangan memakai `127.0.0.1` atau `localhost` pada perangkat teman. Kedua alamat tersebut selalu menunjuk ke perangkat itu sendiri.
6. Tekan `Ctrl+C` pada terminal server untuk menghentikan akses jaringan.
7. Jika server dijalankan di background atau terminal sudah tertutup, klik dua kali `stop-network.bat`.

### Jika tidak dapat diakses

1. Pastikan perangkat tidak menggunakan mobile data/VPN yang memisahkan koneksi.
2. Pastikan fitur client/AP isolation pada router tidak aktif.
3. Pastikan network profile Windows adalah Private.
4. Jalankan ulang `setup-network-firewall.bat` sebagai Administrator.
5. Periksa bahwa port `8000` tidak digunakan program lain.
6. Jalankan ulang `start-network.bat` karena IP dapat berubah setelah Wi-Fi reconnect atau komputer restart.

### Tampilan responsive

Website dirancang untuk:

- Mobile kecil mulai sekitar lebar 320px.
- Android dan iPhone portrait/landscape.
- Tablet dan iPad portrait/landscape.
- Laptop dan desktop.

Navbar berubah menjadi menu mobile, grid berubah menjadi satu kolom, typography mengecil, tombol menjadi lebih mudah disentuh, gambar menggunakan crop responsive, dan konten panjang dibungkus agar tidak keluar layar.

### Catatan keamanan

- Gunakan hanya pada jaringan rumah/kantor yang dipercaya.
- Jangan melakukan port forwarding pada router.
- Jangan mengekspos port `8000` ke internet.
- Admin CMS dapat diakses perangkat jaringan jika alamat admin diketahui. Hentikan server setelah pengujian selesai.
- Untuk akses internet publik tetap gunakan GitHub Pages, bukan mode jaringan lokal.

### Mengubah desain atau program

File utama frontend:

- Layout, navbar, dan footer: `resources/views/layouts/app.blade.php`
- Homepage: `resources/views/portfolio/home.blade.php`
- Contact: `resources/views/portfolio/contact.blade.php`
- Project listing: `resources/views/projects/index.blade.php`
- Project detail: `resources/views/projects/show.blade.php`
- CSS dan design token: `resources/css/app.css`
- JavaScript dan Alpine: `resources/js/app.js`

Setelah mengubah CSS atau JavaScript, jalankan:

```bash
npm run build
```

Kemudian lakukan hard refresh browser dengan `Ctrl+Shift+R`.

## 4. Memeriksa Perubahan Sebelum Push

Jalankan pemeriksaan berikut:

```bash
git status
git diff
npm run build
```

Periksa juga halaman berikut melalui desktop dan mobile:

- `/`
- `/about`
- `/experience`
- `/skills`
- `/projects`
- Setiap halaman project detail
- `/resume`
- `/contact`

Pastikan gambar, tombol, dark mode, menu mobile, dan download CV bekerja.

## 5. Push Source Laravel ke GitHub

Push source digunakan untuk menyimpan kode dan riwayat perubahan. Push source tidak otomatis mengubah website publik GitHub Pages.

```bash
git status
git diff
git add resources database tests README.md TUTORIAL.md start-local.bat publish-pages.bat deploy
git commit -m "Jelaskan perubahan yang dibuat"
git push origin main
```

Jika ada file lain yang memang sengaja diubah, tambahkan file tersebut secara eksplisit. Jangan gunakan `git add .` sebelum memastikan `.env`, credential, dump database, dan file pribadi tidak ikut stage.

Periksa file yang akan di-commit:

```bash
git status
git diff --cached
```

## 6. Publish ke GitHub Pages

Publish dilakukan setelah versi lokal sudah benar.

### Cara termudah

1. Tutup server lain yang menggunakan port `8001`.
2. Klik dua kali `publish-pages.bat`.
3. Script menjalankan production build.
4. Script mengekspor halaman public dari Laravel.
5. Script menyalin foto, gallery, architecture image, dan CV.
6. Script membuat commit di repository `dist`.
7. Script push ke `brillianghulam20.github.io`.
8. Tunggu 1-3 menit hingga GitHub Pages selesai membangun.
9. Buka `https://brillianghulam20.github.io`.
10. Tekan `Ctrl+Shift+R` jika browser masih menampilkan cache lama.

### Memeriksa status deployment

Buka:

`https://github.com/brillianghulam20/brillianghulam20.github.io/actions`

Deployment berhasil jika workflow `pages build and deployment` berstatus hijau atau `success`.

## 7. Perbedaan Push Source dan Publish Website

### `git push origin main` di folder utama

Mendorong kode Laravel ke repository:

`brillianghulam20/brillian-portfolio`

Ini untuk backup source, histori kode, dan deployment Laravel di masa depan.

### `publish-pages.bat`

Mendorong hasil website statis ke repository:

`brillianghulam20/brillianghulam20.github.io`

Ini yang mengubah website publik.

## 8. Troubleshooting

### Website tampil tanpa CSS atau hanya teks putih

1. Hentikan server dengan `Ctrl+C`.
2. Jalankan kembali `start-local.bat`.
3. Pastikan `npm run build` berhasil.
4. Buka kembali website.
5. Tekan `Ctrl+Shift+R`.

Pastikan URL CSS mengembalikan `text/css`, bukan `text/html`.

### Port 8000 sudah digunakan

Tutup terminal Laravel lama. Jika masih digunakan, jalankan:

```powershell
Get-NetTCPConnection -LocalPort 8000 | Select-Object OwningProcess
Stop-Process -Id NOMOR_PID -Force
```

### Perubahan CMS tidak tampil di GitHub Pages

Perubahan CMS tersimpan pada database, tetapi GitHub Pages adalah website statis. Jalankan `publish-pages.bat` untuk membuat dan mengunggah HTML terbaru.

### Project baru tidak ikut dipublikasikan

Pastikan project memiliki:

- Slug yang unik.
- Status `published`.
- Category yang valid.
- Problem dan Solution terisi.

### Jangan menjalankan test pada database konten

Test Laravel menggunakan refresh database. Gunakan database test terpisah melalui `.env.testing`. Jangan arahkan PHPUnit ke database Neon yang berisi konten portfolio.

## 9. Keamanan

- Jangan commit `.env`.
- Jangan menaruh database URL atau password di README/TUTORIAL.
- Rotasi password jika pernah ditempel di chat atau screenshot.
- Periksa screenshot project sebelum dipublikasikan.
- Jangan mengunggah data internal perusahaan, token, password, domain internal, atau data pribadi user.
