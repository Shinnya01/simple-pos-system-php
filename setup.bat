@echo off
setlocal

REM ===============================
REM  PHP Mini Shop Startup Script
REM ===============================

set HOST=myshop.local
set PORT=80
set ROOT=%~dp0

echo -------------------------------------
echo 🚀 Starting PHP Mini Shop
echo URL: http://%HOST%:%PORT%
echo -------------------------------------

REM Start PHP built-in server
start php -S myshop.local:8443 -t "%ROOT%" --cert ssl/server.crt --key ssl/server.key


REM Wait a moment for the server to start
timeout /t 2 >nul

REM Open default web browser automatically
start http://%HOST%:%PORT%

echo ✅ Server is running. Press Ctrl + C to stop.
pause
