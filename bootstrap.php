<?php
session_start();
require_once __DIR__ . '/helpers.php';

require_once 'config.php';
require_once 'db.php';

if (!isset($_SESSION['logged_in']) && basename($_SERVER['PHP_SELF']) != 'login.php' && basename($_SERVER['PHP_SELF']) != 'setup_db.php') {
    header('Location: login.php');
    exit;
}
