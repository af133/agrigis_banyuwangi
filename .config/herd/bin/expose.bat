@ECHO OFF
SETLOCAL ENABLEDELAYEDEXPANSION

REM Determine the directory where the batch file resides
SET "DIR=%~dp0"
SET "PHAR=%DIR%expose.phar"

REM Check if the first argument is "self-update"
IF /I "%~1"=="self-update" (   
    ECHO Fetching latest release information from GitHub...
    REM Query the GitHub API and extract the tag_name line.
    FOR /F "usebackq tokens=2 delims=:, " %%A in (`curl -s "https://api.github.com/repos/exposedev/expose/releases/latest" ^| findstr /i "tag_name"`) do (
        SET "TAG=%%A"
    )
    
    REM Remove any quotes from the TAG and trim spaces.
    SET "TAG=!TAG:"=!"
    SET "TAG=!TAG: =!"
    
    ECHO Latest release tag is: !TAG!
    
    SET "DOWNLOAD_URL=https://github.com/exposedev/expose/raw/refs/tags/!TAG!/builds/expose.phar"
    
    IF "%TEMP%"=="" (
        SET "TMP_DIR=%USERPROFILE%\AppData\Local\Temp"
    ) ELSE (
        SET "TMP_DIR=%TEMP%"
    )
    SET "TMP_FILE=!TMP_DIR!\expose.phar.new"
    DEL "!TMP_FILE!" 2>NUL
    
    ECHO Downloading expose.phar from: !DOWNLOAD_URL!
    curl -L -o "!TMP_FILE!" "!DOWNLOAD_URL!"
    IF ERRORLEVEL 1 (
        ECHO Download failed.
        PAUSE
        EXIT /B 1
    )
    
    IF NOT EXIST "!TMP_FILE!" (
        ECHO Downloaded file not found.
        PAUSE
        EXIT /B 1
    )
    
    ECHO Updating expose.phar...
    COPY /Y "!TMP_FILE!" "!PHAR!"
    IF ERRORLEVEL 1 (
        ECHO Failed to update expose.phar.
        PAUSE
        EXIT /B 1
    )
    
    DEL "!TMP_FILE!"
    ECHO Self-update completed.
    EXIT /B 0
)

REM For all other commands, run expose.phar normally
php "%PHAR%" %*