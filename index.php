<?php
session_start();

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

$page = $_GET['page'] ?? 'home';
$publicPages = ['setup_db']; // remove 'login'

if (!isLoggedIn() && !in_array($page, $publicPages)) {
    header('Location: login.php');
    exit;
}

$file = __DIR__ . "/pages/{$page}.php";
if (file_exists($file)) {
    ob_start();
    include $file;
    $content = ob_get_clean();
} else {
    $content = "<h1>404 - Page not found</h1>";
}

include __DIR__ . '/layout.php';
