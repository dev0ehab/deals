@echo off

echo Starting Scaffolding setup...

set folderPath=%cd%

for /f "delims=" %%A in ('cd') do (
     set folderName=%%~nxA
    )
    echo Current Folder Name: %folderName%
echo.
set /p APP_DOMAIN= Enter App Domain (%folderName%.test):
set /p DB_DATABASE= Enter The Database Name (%folderName%):
set /p DB_USERNAME= Enter The Database Username (root):
set /p DB_PASSWORD= Enter The Database Password (""):
echo.

IF "%APP_DOMAIN%"=="" (
	SET APP_DOMAIN=%folderName%.test
)
IF "%DB_DATABASE%"=="" (
	SET DB_DATABASE=%folderName%
)
IF "%DB_USERNAME%"=="" (
	SET DB_USERNAME=root
)

IF "%DB_PASSWORD%" NEQ "" (
    echo creating database without password...
    call mysql -u %DB_USERNAME% -e "CREATE DATABASE IF NOT EXISTS %DB_DATABASE% "
    echo.
) ELSE (
     echo creating database with password...
     call mysql -u %DB_USERNAME% --password=%DB_PASSWORD% -e "CREATE DATABASE IF NOT EXISTS %DB_DATABASE% "
     echo.
)

echo APP_DOMAIN:%APP_DOMAIN%
echo DB_DATABASE:%DB_DATABASE%
echo DB_USERNAME:%DB_USERNAME%
echo DB_PASSWORD:%DB_PASSWORD%
echo.


echo Copying .env.example file to .env file
echo.

copy .env.example .env
echo .env file is ready to use
echo.

set "search_app_domain=APP_DOMAIN=scaffolding.test"
set "replace_app_domain=APP_DOMAIN=%APP_DOMAIN: =%%"
set "search_db_database=DB_DATABASE=scaffolding"
set "replace_db_database=DB_DATABASE=%DB_DATABASE: =%%"
set "search_db_username=DB_USERNAME=root"
set "replace_db_username=DB_USERNAME=%DB_USERNAME%"
IF "%DB_PASSWORD%" NEQ [] (
set "search_db_password=DB_PASSWORD="
set "replace_db_password=DB_PASSWORD=%DB_PASSWORD%"
)
set "envFile=.env"

echo Setting up .env file
echo.
powershell -Command "(gc  \"%envFile%\") -replace '%search_app_domain%', '%replace_app_domain%' | Out-File -encoding UTF8  \"%envFile%\"
echo set APP_DOMAIN to %APP_DOMAIN%
echo.
powershell -Command "(gc  \"%envFile%\") -replace '%search_db_database%', '%replace_db_database%' | Out-File -encoding UTF8  \"%envFile%\"
echo set DB_DATABASE to %DB_DATABASE%
echo.
powershell -Command "(gc  \"%envFile%\") -replace '%search_db_username%', '%replace_db_username%' | Out-File -encoding UTF8  \"%envFile%\"
echo set DB_USERNAME to %DB_USERNAME%
echo.
IF NOT "%DB_PASSWORD%" NEQ [] (
powershell -Command "(gc  \"%envFile%\") -replace '%search_db_password%', '%replace_db_password%' | Out-File -encoding UTF8  \"%envFile%\"
echo set DB_PASSWORD to %DB_PASSWORD%
echo.
)

echo Done Setting up .env file
echo.

echo Installing composer dependencies

call composer install

echo Composer installed successfully

echo Setting up Application Key
php artisan key:generate
echo Application Key Generated successfully

echo Migrating the database
@REM call composer app:clear
php artisan migrate:fresh
echo Database Migrated successfully

echo Seeding the database
php artisan db:seed
echo Database Seeded successfully

echo Setting storage link
php artisan storage:link
echo Storage Linked successfully

echo installing npm dependencies
call npm install
echo npm dependencies installed successfully

echo compiling assets
call npm run dev
echo assets compiled successfully

break>"%folderPath%\storage\installed"
for /F "usebackq tokens=1,2 delims==" %%i in (`wmic os get LocalDateTime /VALUE 2^>NUL`) do if '.%%i.'=='.LocalDateTime.' set ldt=%%j
set ldt=%ldt:~0,4%-%ldt:~4,2%-%ldt:~6,2% %ldt:~8,2%:%ldt:~10,2%:%ldt:~12,6%

@echo Installer successfully INSTALLED on %ldt%> "%folderPath%\storage\installed"

echo cleaning up
call composer app:clear
call composer dump-autoload
echo Done cleaning up

echo Application installed successfully and is ready to use.
echo APP_URL: http://%APP_DOMAIN%




