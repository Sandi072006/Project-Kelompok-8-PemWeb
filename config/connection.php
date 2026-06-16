<?php

function getDB() {
    static $pdo = null;

    if ($pdo === null) {
        try {
            $host     = 'localhost';
            $dbname   = 'stockmate';
            $charset  = 'utf8mb4';
            $username = 'root';
            $password = '';
            
            $dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";
            
            $pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES    => false,
                PDO::ATTR_PERSISTENT          => false,
                PDO::MYSQL_ATTR_INIT_COMMAND  => "SET NAMES utf8mb4 COLLATE utf8mb4_general_ci",
            ]);
            
        } catch (PDOException $e) {
            http_response_code(500);
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Database Connection Error</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f5f5f5;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        margin: 0;
                    }
                    .error-box {
                        background-color: white;
                        border-left: 4px solid #d32f2f;
                        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                        padding: 20px;
                        border-radius: 4px;
                        max-width: 500px;
                    }
                    h1 {
                        color: #d32f2f;
                        margin-top: 0;
                    }
                    p {
                        color: #666;
                        line-height: 1.6;
                    }
                    .error-detail {
                        background-color: #f5f5f5;
                        border: 1px solid #ddd;
                        padding: 10px;
                        border-radius: 4px;
                        font-family: monospace;
                        font-size: 12px;
                        color: #333;
                        margin-top: 10px;
                    }
                </style>
            </head>
            <body>
                <div class="error-box">
                    <h1>❌ Koneksi Database Gagal</h1>
                    <p><strong>Pesan Error:</strong></p>
                    <div class="error-detail"><?php echo htmlspecialchars($e->getMessage()); ?></div>
                    <p style="margin-top: 15px; color: #999; font-size: 12px;">
                        Pastikan:<br>
                        • MySQL server sedang berjalan<br>
                        • Database 'stockmate' sudah dibuat<br>
                        • Username dan password sudah benar
                    </p>
                </div>
            </body>
            </html>
            <?php
            exit;
        }
    }

    return $pdo;
}
