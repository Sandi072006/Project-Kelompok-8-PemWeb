<?php

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

if (!defined('ROOT')) {
	define('ROOT', dirname(__DIR__));
}

if (!defined('BASE_URL')) {
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
	$base_url = $protocol . $_SERVER['HTTP_HOST'];
	$request_uri = $_SERVER['REQUEST_URI'];
	$script_name = $_SERVER['SCRIPT_NAME'];
	$base_url .= str_replace(basename($script_name), '', $script_name);
	define('BASE_URL', rtrim($base_url, '/'));
}
