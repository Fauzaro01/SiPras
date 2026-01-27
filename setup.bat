@echo off
echo ========================================
echo   SiPras - Sistem Prasarana Sekolah
echo   Quick Start Script
echo ========================================
echo.

echo [1/5] Checking if .env file exists...
if not exist ".env" (
    echo .env file not found. Copying from .env.example...
    copy .env.example .env
    echo [!] Please configure your database settings in .env file
    pause
)

echo.
echo [2/5] Installing Composer dependencies...
call composer install

echo.
echo [3/5] Installing NPM dependencies...
call npm install

echo.
echo [4/5] Generating application key...
call php artisan key:generate

echo.
echo [5/5] Running migrations and seeders...
call php artisan migrate:fresh --seed

echo.
echo ========================================
echo   Setup Complete!
echo ========================================
echo.
echo Next steps:
echo 1. Open a terminal and run: npm run dev
echo 2. Open another terminal and run: php artisan serve
echo 3. Open browser to http://localhost:8000
echo.
echo Login credentials:
echo - Admin: username=admin, password=admin123
echo - Siswa: NIS=12345, password=12345
echo.
pause
