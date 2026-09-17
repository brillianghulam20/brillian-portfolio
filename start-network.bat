@echo off
setlocal EnableDelayedExpansion
cd /d "%~dp0"

echo ========================================
echo  Brillian Portfolio - Local Network
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

echo Building responsive frontend assets...
call npm run build
if errorlevel 1 goto :error

for /f "usebackq delims=" %%I in (`powershell.exe -NoProfile -ExecutionPolicy Bypass -File "%~dp0deploy\get-lan-ip.ps1"`) do set LAN_IP=%%I

if not defined LAN_IP (
    echo Tidak dapat menemukan alamat IP jaringan.
    echo Pastikan Wi-Fi atau LAN sudah terhubung.
    goto :error
)

echo.
echo Website komputer ini : http://127.0.0.1:8000
echo Website perangkat lain: http://!LAN_IP!:8000
echo Admin perangkat lain  : http://!LAN_IP!:8000/admin/login
echo.
echo Syarat:
echo - Semua perangkat terhubung ke Wi-Fi/LAN yang sama.
echo - Network profile Windows diatur ke Private.
echo - setup-network-firewall.bat sudah pernah dijalankan sebagai Administrator.
echo.
echo Tekan Ctrl+C untuk menghentikan server.
start "" "http://127.0.0.1:8000"
call php artisan serve --host=0.0.0.0 --port=8000
exit /b 0

:error
echo.
echo Gagal menjalankan mode jaringan. Periksa pesan di atas.
pause
exit /b 1
