@echo off
cd /d C:\Cours\4A_S8\PWACovoitV4\CovoiturageApp

REM Start Laravel server
start cmd /k "php artisan serve"

REM Start npm
start cmd /k "npm run dev"
