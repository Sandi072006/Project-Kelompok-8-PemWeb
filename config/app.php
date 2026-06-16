<?php

define('ROOT', __DIR__);

require_once ROOT . '/config/app.php';        

require_once ROOT . '/config/connection.php';   

require_once ROOT . '/models/User.php';
require_once ROOT . '/models/Barang.php';
require_once ROOT . '/models/Supplier.php';
require_once ROOT . '/models/Pemasokan.php';
require_once ROOT . '/models/StockOut.php';

require_once ROOT . '/controllers/AuthController.php';
require_once ROOT . '/controllers/DashboardController.php';
require_once ROOT . '/controllers/BarangController.php';
require_once ROOT . '/controllers/SupplierController.php';
require_once ROOT . '/controllers/PemasokanController.php';
require_once ROOT . '/controllers/LaporanController.php';

require_once ROOT . '/helpers/Router.php';
