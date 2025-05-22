@echo off
setlocal enabledelayedexpansion

REM Set the HOME variable to the appropriate directory
set "HERD_HOME=%USERPROFILE%\.config\herd\bin"
set "PHP_CONFIG_DIR=%USERPROFILE%\.config\herd\config\php\"
set "PHP_BIN_DIR=%USERPROFILE%\.config\herd\bin\php"

if "%1"=="php" (
    if "%2"=="--site=*" (
        set "SITE=%2"
        set "SITE=%SITE:*=*"
        for /f "tokens=*" %%A in ('php "%HERD_HOME%\herd.phar" which-php %SITE%') do (
            set "PHP_EXECUTABLE=%%A"
        )
        shift /2
    ) else (
        for /f "tokens=*" %%A in ('php "%HERD_HOME%\herd.phar" which-php') do (
            set "PHP_EXECUTABLE=%%A"
        )
        shift
    )

    for /f "tokens=1,* delims= " %%a in ("%*") do set ALL_BUT_FIRST=%%b

    "!PHP_EXECUTABLE!" !ALL_BUT_FIRST!
    exit /b
)

if "%1"=="composer" (
    if "%2"=="--site=*" (
        set "SITE=%2"
        set "SITE=%SITE:*=*"
        for /f "tokens=*" %%A in ('php "%HERD_HOME%\herd.phar" which-php %SITE%') do (
            set "PHP_EXECUTABLE=%%A"
        )
        shift /2
    ) else (
        for /f "tokens=*" %%A in ('php "%HERD_HOME%\herd.phar" which-php') do (
            set "PHP_EXECUTABLE=%%A"
        )
        shift
    )

    for /f "tokens=1,* delims= " %%a in ("%*") do set ALL_BUT_FIRST=%%b

    "!PHP_EXECUTABLE!" "%HERD_HOME%\composer.phar" !ALL_BUT_FIRST!
    exit /b
)



if "%1"=="debug" (
    for /f "tokens=*" %%A in ('php "%HERD_HOME%\herd.phar" which-php') do (
        set "PHP_EXECUTABLE=%%A"
    )
    shift

    for /f "tokens=1,* delims= " %%a in ("%*") do set ALL_BUT_FIRST=%%b
    REM Set XDEBUG_SESSION to 1
    set "XDEBUG_SESSION=1"

    REM Extract the parent folder name from the PHP executable path
    for %%F in ("!PHP_EXECUTABLE!\..") do (
        set "PHP_VERSION_FOLDER=%%~nxF"
    )

    REM Extract version number from the parent folder name
    set "PHP_VERSION_NUMBER=!PHP_VERSION_FOLDER:~3!"
    set "PHP_INI_SCAN_DIR=!PHP_BIN_DIR!!PHP_VERSION_NUMBER!"

    "!PHP_EXECUTABLE!" -c "!PHP_CONFIG_DIR!!PHP_VERSION_NUMBER!\debug\debug.ini" !ALL_BUT_FIRST!
    exit /b
)



if "%1"=="coverage" (
    for /f "tokens=*" %%A in ('php "%HERD_HOME%\herd.phar" which-php') do (
        set "PHP_EXECUTABLE=%%A"
    )
    shift

    for /f "tokens=1,* delims= " %%a in ("%*") do set ALL_BUT_FIRST=%%b
    REM Set XDEBUG_SESSION to 1
    set "XDEBUG_MODE=coverage"

    REM Extract the parent folder name from the PHP executable path
    for %%F in ("!PHP_EXECUTABLE!\..") do (
        set "PHP_VERSION_FOLDER=%%~nxF"
    )

    REM Extract version number from the parent folder name
    set "PHP_VERSION_NUMBER=!PHP_VERSION_FOLDER:~3!"
    set "PHP_INI_SCAN_DIR=!PHP_BIN_DIR!!PHP_VERSION_NUMBER!"

    "!PHP_EXECUTABLE!" -c "!PHP_CONFIG_DIR!!PHP_VERSION_NUMBER!\debug\debug.ini" !ALL_BUT_FIRST!
    exit /b
)

:: Check if the command is "share"
if "%1"=="share" (
    :: Initialize a variable to count arguments beyond the first one
    set /a argCount=0

    :: Loop through all arguments to count them
    for %%x in (%*) do set /a argCount+=1

    :: Subtract one for the initial 'herd' argument, so we only count arguments after 'herd'
    set /a argCount-=1

        if !argCount! GEQ 1 (

            :: Additional parameters detected. Forwarding all parameters to expose share.
            shift
            set "command="
            for %%a in (%*) do set command=!command! %%a

            :: Execute the command with all parameters following 'herd share'
            "%HERD_HOME%/expose" share !command:~7!

            exit /b
        ) else (
            :: Get the current directory's name
            for /f "delims=" %%a in ('cd') do set HOST=%%~nxa


            :: Get the TLD
            for /f "tokens=*" %%a in ('php "%HERD_HOME%/herd.phar" tld') do set TLD=%%a

            :: Check for port 443 in the config
            findstr "443" "%USERPROFILE%\.config\herd\config\valet\Nginx\!HOST!*" >nul 2>&1
            if !errorlevel!==0 (
                set PORT=443
            ) else (
                set PORT=80
            )

            :: Prepare the remaining arguments
            for /f "tokens=1,* delims= " %%a in ("%*") do set ALL_BUT_FIRST=%%b

            :: Execute the share command
            "%HERD_HOME%/expose" share !HOST!.!TLD!:!PORT! !ALL_BUT_FIRST!

            exit /b
        )
)

for /f "tokens=*" %%A in ('php "%HERD_HOME%\find-usable-php.php"') do (
    set "PHP=%%A"
)

if "%PHP%"=="" (
    echo "No usable PHP version found"
    exit /b
)

if "%1"=="use" (
    "!PHP!" -d error_reporting="E_ALL & ~E_DEPRECATED" "%~dp0herd.phar" %*
    exit /b
)

"!PHP!" "%~dp0herd.phar" %*