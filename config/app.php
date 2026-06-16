<?php

define('APP_NAME', 'StockMate');
define('APP_VERSION', '1.0.0');

if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
    $scheme = 'https';
} else {
    $scheme = 'http';
}

if (isset($_SERVER['HTTP_HOST'])) {
    $host = $_SERVER['HTTP_HOST'];
} else {
    $host = 'localhost';
}

if (isset($_SERVER['SCRIPT_NAME'])) {
    $scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
} else {
    $scriptDir = '';
}

if ($scriptDir === '' || $scriptDir === '/') {
    $basePath = '';
} else {
    $basePath = $scriptDir;
}

define('BASE_URL', $scheme . '://' . $host . $basePath);

date_default_timezone_set('Asia/Jakarta');

session_start();
