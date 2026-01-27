@echo off
echo ========================================
echo   Starting SiPras Application
echo ========================================
echo.
echo Starting Laravel server and Vite...
echo Please wait...
echo.
echo Press Ctrl+C to stop all servers
echo.

start "Vite Dev Server" cmd /k "npm run dev"
timeout /t 3 /nobreak > nul
start "Laravel Server" cmd /k "php artisan serve"

echo.
echo ========================================
echo   Servers Started!
echo ========================================
echo.
echo Vite: Running in separate window
echo Laravel: http://localhost:8000
echo.
echo To stop: Close the terminal windows
echo ========================================
