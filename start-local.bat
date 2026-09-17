@echo off
setlocal
cd /d "%~dp0"

echo ========================================
echo  Brillian Portfolio - Local Development
echo ========================================

if not exist vendor\autoload.php (
    echo Installing PHP dependencies...
    call composer install
    if errorlevel 1 goto :error
)

if not exist node_modules (
    echo Installing frontend dependencies...
    call npm install
    if errorlevel 1 goto :error
)

call php artisan optimize:clear
call php artisan migrate --force
if errorlevel 1 goto :error
call php artisan portfolio:install
if not exist public\storage call php artisan storage:link
echo Building frontend assets...
call npm run build
if errorlevel 1 goto :error

start "" "http://127.0.0.1:8000"

echo.
echo Website: http://127.0.0.1:8000
echo Admin:   http://127.0.0.1:8000/admin/login
echo Perubahan Blade/PHP tampil setelah refresh browser.
echo Setelah mengubah CSS/JavaScript, jalankan kembali start-local.bat.
echo Tekan Ctrl+C untuk menghentikan server Laravel.
echo.
call php artisan serve --host=127.0.0.1 --port=8000
exit /b 0

:error
echo.
echo Gagal menjalankan website. Periksa pesan error di atas.
pause
exit /b 1
