TITLE Magazijn development server
ECHO OFF
cls

:: settings/variables
SET localhost=127.0.0.1
SET port=6969

:: close program instructions
ECHO Ctrl+C om de development server te stoppen
ECHO:

:: open default browser with expected url
start "" http://%localhost%:%port%
:: start development server
php artisan serve --port=%port%
