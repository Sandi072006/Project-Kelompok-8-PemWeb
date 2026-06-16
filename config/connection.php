<?php

function getDB() {
    static $pdo = null;

    if ($pdo === null) {
        try {
            $dsn = 'mysql:host=localhost;dbname=stockmate;charset=utf8mb4';
            $pdo = new PDO($dsn, 'root', '', [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            die('Koneksi database gagal: ' . $e->getMessage());
        }
    }

    return $pdo;
}
