<?php
// ─── Bootstrap ─────────────────────────────────────────────────
define('ROOT', __DIR__);

require_once ROOT . '/config/app.php';        // BASE_URL, session_start
require_once ROOT . '/config/connection.php';   // getDB()

// ─── Load Models ───────────────────────────────────────────────
require_once ROOT . '/models/User.php';
require_once ROOT . '/models/Barang.php';
require_once ROOT . '/models/Supplier.php';
require_once ROOT . '/models/Pemasokan.php';
require_once ROOT . '/models/StockOut.php';

// ─── Load Controllers ──────────────────────────────────────────
require_once ROOT . '/controllers/AuthController.php';
require_once ROOT . '/controllers/DashboardController.php';
require_once ROOT . '/controllers/BarangController.php';
require_once ROOT . '/controllers/SupplierController.php';
require_once ROOT . '/controllers/PemasokanController.php';
require_once ROOT . '/controllers/LaporanController.php';
require_once ROOT . '/controllers/StockOutController.php';

// ─── Load Router & Dispatch ────────────────────────────────────
require_once ROOT . '/helpers/Router.php';