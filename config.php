<?php
if (file_exists('.env')) {
    $env = parse_ini_file('.env');
}

define('APP_NAME', $env['APP_NAME'] ?? 'My PHP App');
define('APP_AUTHOR', $env['APP_AUTHOR'] ?? 'Unknown');
define('DB_PATH', $env['DB_PATH'] ?? 'database.sqlite');
