<?php

define('APP_NAME', 'StockMate');
define('APP_VERSION', '1.0.0');

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
$basePath = ($scriptDir === '' || $scriptDir === '/') ? '' : $scriptDir;

define('BASE_URL', $scheme . '://' . $host . $basePath);

// Timezone
date_default_timezone_set('Asia/Jakarta');

// Session
session_start();
