@echo off
setlocal EnableDelayedExpansion

net session >nul 2>&1
if not %errorlevel%==0 (
    echo Meminta hak Administrator untuk mengatur Windows Firewall...
    powershell.exe -NoProfile -ExecutionPolicy Bypass -Command "Start-Process -FilePath '%~f0' -Verb RunAs"
    exit /b
)

echo Network profile aktif:
powershell.exe -NoProfile -Command "Get-NetConnectionProfile | Where-Object { $_.IPv4Connectivity -ne 'Disconnected' } | Select-Object InterfaceAlias,Name,NetworkCategory | Format-Table -AutoSize"
echo.
choice /C YN /M "Ubah network profile aktif menjadi Private agar perangkat lain dapat mengakses"
if errorlevel 2 goto :firewall

powershell.exe -NoProfile -Command "Get-NetConnectionProfile | Where-Object { $_.IPv4Connectivity -ne 'Disconnected' } | Set-NetConnectionProfile -NetworkCategory Private"
if errorlevel 1 (
    echo Gagal mengubah network profile ke Private.
    pause
    exit /b 1
)

:firewall
echo Mengizinkan akses TCP port 8000 hanya dari jaringan lokal...
netsh advfirewall firewall delete rule name="Brillian Portfolio Local Network" >nul 2>&1
netsh advfirewall firewall add rule name="Brillian Portfolio Local Network" dir=in action=allow protocol=TCP localport=8000 profile=private remoteip=localsubnet

if errorlevel 1 (
    echo Gagal membuat aturan firewall.
    pause
    exit /b 1
)

echo.
echo Firewall berhasil dikonfigurasi.
echo Akses hanya diizinkan dari local subnet pada jaringan Private.
powershell.exe -NoProfile -Command "Get-NetConnectionProfile | Where-Object { $_.IPv4Connectivity -ne 'Disconnected' } | Select-Object InterfaceAlias,Name,NetworkCategory | Format-Table -AutoSize"
pause
