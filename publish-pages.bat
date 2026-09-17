@echo off
setlocal
cd /d "%~dp0"

echo ========================================
echo  Publish ke GitHub Pages
echo ========================================

call php artisan optimize:clear
call npm run build
if errorlevel 1 goto :error

if not exist dist\.git (
    echo Menghubungkan repository GitHub Pages...
    if exist dist rmdir /s /q dist
    git clone https://github.com/brillianghulam20/brillianghulam20.github.io.git dist
    if errorlevel 1 goto :error
)

start "Static Export Server" /min cmd /c "cd /d ""%~dp0"" && php artisan serve --host=127.0.0.1 --port=8001"

echo Menunggu server export...
timeout /t 4 /nobreak >nul

set SOURCE_URL=http://127.0.0.1:8001
set SITE_URL=https://brillianghulam20.github.io
bash deploy/export-static.sh dist
if errorlevel 1 goto :error

git -C dist add .
git -C dist diff --cached --quiet
if not errorlevel 1 (
    echo Tidak ada perubahan untuk dipublikasikan.
    goto :success
)

git -C dist commit -m "Update portfolio content"
if errorlevel 1 goto :error
git -C dist push origin main
if errorlevel 1 goto :error

:success
taskkill /FI "WINDOWTITLE eq Static Export Server*" /T /F >nul 2>&1
echo.
echo Publish berhasil.
echo Website: https://brillianghulam20.github.io
start "" "https://brillianghulam20.github.io"
pause
exit /b 0

:error
taskkill /FI "WINDOWTITLE eq Static Export Server*" /T /F >nul 2>&1
echo.
echo Publish gagal. Periksa pesan error di atas.
pause
exit /b 1
