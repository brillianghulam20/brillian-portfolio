# Deployment VPS

## Kebutuhan Server

- Ubuntu 24.04 atau versi LTS terbaru
- Nginx
- PHP 8.5 FPM beserta `bcmath`, `curl`, `fileinfo`, `mbstring`, `pgsql`, `xml`, dan `zip`
- PostgreSQL 16 atau lebih baru
- Composer 2, Node.js 24, npm, Git, dan Certbot
- Domain dengan DNS `A` record yang mengarah ke IP VPS

## Instalasi Pertama

1. Buat database PostgreSQL dan user khusus aplikasi.
2. Upload atau clone repository ke `/var/www/brillian-portfolio/current`.
3. Salin `deploy/.env.production.example` menjadi `.env` dan isi URL, database, serta credential admin.
4. Jalankan `php artisan key:generate` untuk membuat `APP_KEY`.
5. Salin `deploy/nginx.conf` ke `/etc/nginx/sites-available/brillian-portfolio`, ubah `server_name`, lalu aktifkan konfigurasi dengan symlink ke `sites-enabled`.
6. Sesuaikan socket PHP pada konfigurasi Nginx jika versi PHP server berbeda.
7. Pastikan database baru masih kosong, lalu jalankan `APP_URL=https://domain-anda.example bash deploy/deploy.sh`. Seeder hanya berjalan ketika profil belum tersedia, sehingga update berikutnya tidak menimpa konten CMS.
8. Aktifkan HTTPS dengan `sudo certbot --nginx -d domain-anda.example`.
9. Verifikasi `/up`, homepage, project detail, download CV, login admin, dan upload file.

## Update Berikutnya

Tarik revisi terbaru lalu jalankan kembali:

```bash
APP_URL=https://domain-anda.example bash deploy/deploy.sh
```

## Operasional

Tambahkan cron berikut agar Laravel scheduler berjalan:

```cron
* * * * * cd /var/www/brillian-portfolio/current && php artisan schedule:run >> /dev/null 2>&1
```

Backup harian minimal mencakup database PostgreSQL dan `storage/app/public`. Jangan menyimpan `.env`, dump database, private key, atau credential deployment di repository.

## Free Tier: Render + Neon

Repository juga menyediakan `Dockerfile`, `render.yaml`, dan `deploy/render-start.sh` untuk publikasi gratis:

1. Push repository ke GitHub.
2. Buat project PostgreSQL Free di Neon dan salin pooled connection string dengan `sslmode=require`.
3. Di Render, pilih **New > Blueprint**, hubungkan repository, dan gunakan `render.yaml`.
4. Isi secret `DB_URL`, `ADMIN_EMAIL`, dan `ADMIN_PASSWORD` saat diminta.
5. Setelah deploy selesai, buka URL `https://brillian-portfolio.onrender.com` atau URL unik yang diberikan Render.

Render free web service dapat sleep ketika tidak digunakan sehingga request pertama lebih lambat. Filesystem free tier bersifat ephemeral: foto profil dan CV bawaan dipulihkan otomatis, tetapi upload baru melalui CMS sebaiknya dipindahkan ke object storage sebelum digunakan sebagai penyimpanan jangka panjang.
