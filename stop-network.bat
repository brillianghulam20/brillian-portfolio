@echo off
setlocal

echo Menghentikan Brillian Portfolio pada port 8000...
powershell.exe -NoProfile -Command "$connections = Get-NetTCPConnection -LocalPort 8000 -State Listen -ErrorAction SilentlyContinue; if (-not $connections) { Write-Output 'Server tidak sedang berjalan.'; exit 0 }; foreach ($connection in $connections) { Stop-Process -Id $connection.OwningProcess -Force -ErrorAction SilentlyContinue; Write-Output ('Server dihentikan. PID: ' + $connection.OwningProcess) }"
pause
