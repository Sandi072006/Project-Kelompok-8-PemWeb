<?php

if (isset($_SERVER['REQUEST_URI'])) {
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
} else {
    $requestUri = '/';
}

$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$basePath   = rtrim(str_replace('\\', '/', $scriptName), '/');

if ($basePath !== '' && $basePath !== '/') {
    if (strpos($requestUri, $basePath) === 0) {
        $path = substr($requestUri, strlen($basePath));
    } else {
        $path = $requestUri;
    }
} else {
    $path = $requestUri;
}

$path = strtok($path, '?');   

$path = rtrim($path, '/');    

if ($path === '') {
    $path = '/';
}

$routes = [

    '/'              => ['AuthController',      'index'],
    '/login'         => ['AuthController',      'index'],
    '/login/proses'  => ['AuthController',      'login'],
    '/logout'        => ['AuthController',      'logout'],

    '/dashboard'          => ['DashboardController', 'petugas'],
    '/admin/dashboard'    => ['DashboardController', 'admin'],

    '/barang'             => ['BarangController', 'index'],
    '/barang/detail'      => ['BarangController', 'detail'],
    '/barang/stock-out/simpan'   => ['BarangController', 'simpanStockOutPetugas'],
    '/barang/stock-out/batalkan' => ['BarangController', 'batalkanStockOutPetugas'],

    '/admin/barang'           => ['BarangController', 'indexAdmin'],
    '/admin/barang/detail'    => ['BarangController', 'detailAdmin'],
    '/admin/barang/tambah'    => ['BarangController', 'tambah'],
    '/admin/barang/simpan'    => ['BarangController', 'simpan'],
    '/admin/barang/edit'      => ['BarangController', 'edit'],
    '/admin/barang/update'    => ['BarangController', 'update'],
    '/admin/barang/hapus'     => ['BarangController', 'hapus'],
    '/admin/barang/stock-out/simpan' => ['BarangController', 'simpanStockOut'],
    '/admin/barang/stock-out/batalkan'  => ['BarangController', 'batalkanStockOut'],

    '/supplier'           => ['SupplierController', 'index'],
    '/supplier/detail'    => ['SupplierController', 'detail'],

    '/admin/supplier'           => ['SupplierController', 'indexAdmin'],
    '/admin/supplier/detail'    => ['SupplierController', 'detailAdmin'],
    '/admin/supplier/tambah'    => ['SupplierController', 'tambah'],
    '/admin/supplier/simpan'    => ['SupplierController', 'simpan'],
    '/admin/supplier/edit'      => ['SupplierController', 'edit'],
    '/admin/supplier/update'    => ['SupplierController', 'update'],
    '/admin/supplier/hapus'     => ['SupplierController', 'hapus'],

    '/pemasokan'          => ['PemasokanController', 'index'],
    '/pemasokan/detail'   => ['PemasokanController', 'detail'],
    '/pemasokan/tambah'   => ['PemasokanController', 'tambah'],
    '/pemasokan/simpan'   => ['PemasokanController', 'simpan'],
    '/pemasokan/batalkan' => ['PemasokanController', 'batalkan'],

    '/admin/pemasokan'          => ['PemasokanController', 'indexAdmin'],
    '/admin/pemasokan/detail'   => ['PemasokanController', 'detailAdmin'],
    '/admin/pemasokan/tambah'   => ['PemasokanController', 'tambahAdmin'],
    '/admin/pemasokan/simpan'   => ['PemasokanController', 'simpanAdmin'],
    '/admin/pemasokan/batalkan' => ['PemasokanController', 'batalkanAdmin'],


    '/admin/laporan'      => ['LaporanController', 'index'],
];

if (array_key_exists($path, $routes)) {
    
    $controllerName = $routes[$path][0]; 
    $method         = $routes[$path][1]; 

    $controller = new $controllerName();
    
    $controller->$method();

} else {
    http_response_code(404);
    echo '<h1>404 — Halaman tidak ditemukan</h1>';
    echo '<a href="' . BASE_URL . '/login">Kembali ke halaman Login</a>';
}
