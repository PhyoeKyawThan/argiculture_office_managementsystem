@echo off
setlocal enabledelayedexpansion

echo ===================================================
echo   Laravel Windows Application Setup Environment
echo ===================================================

echo.
echo [1/6] Checking System Prerequisites...
where php >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERROR] PHP is not installed or not in your PATH system variables.
    exit /b 1
)
where composer >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERROR] Composer is not installed or not in your PATH system variables.
    exit /b 1
)
where npm >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERROR] NodeJS/NPM is not installed or not in your PATH system variables.
    exit /b 1
)

echo.
echo [2/6] Verifying LibreOffice Installation...
set "LIBRA_PATH=C:\Program Files\LibreOffice\program\soffice.exe"
if not exist "!LIBRA_PATH!" (
    echo LibreOffice not found. Downloading stable runtime container via curl...
    curl -L -o "%TEMP%\LibreOffice.msi" "https://mirrors.cloud.tencent.com/libreoffice/libreoffice/stable/24.2.5/win/x86_64/LibreOffice_24.2.5_Win_x86-64.msi"
    
    if exist "%TEMP%\LibreOffice.msi" (
        echo Installing LibreOffice silently... Please wait...
        msiexec /i "%TEMP%\LibreOffice.msi" /qn /norestart
        del /f /q "%TEMP%\LibreOffice.msi"
        echo [SUCCESS] LibreOffice installed successfully!
    ) else (
        echo [ERROR] Download failed from mirror source. Please install LibreOffice manually.
    )
) else (
    echo [SUCCESS] LibreOffice detected at !LIBRA_PATH!
)

echo.
echo [3/6] Configuring Burmese Font Requirements...
set "FONT_DIR=%WINDIR%\Fonts"
set "FONT_NAME=Pyidaungsu-2.5.3_Regular.ttf"
set "FONT_URL=https://mmunicode.org.mm/downloads/fonts/Pyidaungsu-2.5.3_Regular.ttf"

if not exist "!FONT_DIR!\Pyidaungsu.ttf" if not exist "!FONT_DIR!\Pyidaungsu-2.5.3_Regular.ttf" (
    echo Pyidaungsu font missing. Downloading from official mmunicode engine...
    curl -L -o "%TEMP%\!FONT_NAME!" "!FONT_URL!"
    
    if exist "%TEMP%\!FONT_NAME!" (
        echo Registering Pyidaungsu font into Windows Registry...
        copy /y "%TEMP%\!FONT_NAME!" "!FONT_DIR!\" >nul
        reg add "HKLM\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Fonts" /v "Pyidaungsu (TrueType)" /t REG_SZ /d "!FONT_NAME!" /f >nul
        del /f /q "%TEMP%\!FONT_NAME!" >nul
        echo [SUCCESS] Pyidaungsu Font configured and installed successfully.
    ) else (
        echo [ERROR] Failed to download Pyidaungsu font. PDF renders may break layout mappings.
    )
) else (
    echo [SUCCESS] Pyidaungsu font is already installed.
)

echo.
echo [4/6] Installing PHP Backend Dependencies via Composer...
call composer install

echo.
echo [5/6] Building App Environment Key and Migrations...
if not exist .env (
    echo Copying .env.example configuration file...
    copy .env.example .env
)
call php artisan key:generate

if not exist database\database.sqlite (
    echo Creating SQLite Local Database file storage...
    type nul > database\database.sqlite
)
call php artisan migrate --force

echo.
echo [6/6] Installing Frontend Asset Nodes...
call npm install
call npm run build

echo.
echo ===================================================
echo   Setup finalized! Run 'composer dev' to launch.
echo ===================================================
pause