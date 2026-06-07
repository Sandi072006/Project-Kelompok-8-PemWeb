<?php
// ─── Router ────────────────────────────────────────────────────
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$basePath   = rtrim(str_replace('\\', '/', $scriptName), '/');

if ($basePath !== '' && $basePath !== '/' && strpos($requestUri, $basePath) === 0) {
    $path = substr($requestUri, strlen($basePath));
} else {
    $path = $requestUri;
}

$path = strtok($path, '?');   // buang query string
$path = rtrim($path, '/');    // buang trailing slash
$path = $path === '' ? '/' : $path;

// ─── Daftar Routes ─────────────────────────────────────────────
$routes = [

    // AUTH
    '/'              => ['AuthController',      'index'],
    '/login'         => ['AuthController',      'index'],
    '/login/proses'  => ['AuthController',      'login'],
    '/logout'        => ['AuthController',      'logout'],

    // DASHBOARD
    '/dashboard'          => ['DashboardController', 'petugas'],
    '/admin/dashboard'    => ['DashboardController', 'admin'],

    // BARANG — PETUGAS
    '/barang'             => ['BarangController', 'index'],
    '/barang/detail'      => ['BarangController', 'detail'],

    // BARANG — ADMIN
    '/admin/barang'           => ['BarangController', 'indexAdmin'],
    '/admin/barang/detail'    => ['BarangController', 'detailAdmin'],
    '/admin/barang/tambah'    => ['BarangController', 'tambah'],
    '/admin/barang/simpan'    => ['BarangController', 'simpan'],
    '/admin/barang/edit'      => ['BarangController', 'edit'],
    '/admin/barang/update'    => ['BarangController', 'update'],
    '/admin/barang/hapus'     => ['BarangController', 'hapus'],
    '/admin/barang/stock-out/simpan' => ['BarangController', 'simpanStockOut'],
    '/admin/barang/stock-out/hapus'  => ['BarangController', 'hapusStockOut'],

    // SUPPLIER — PETUGAS
    '/supplier'           => ['SupplierController', 'index'],
    '/supplier/detail'    => ['SupplierController', 'detail'],

    // SUPPLIER — ADMIN
    '/admin/supplier'           => ['SupplierController', 'indexAdmin'],
    '/admin/supplier/detail'    => ['SupplierController', 'detailAdmin'],
    '/admin/supplier/tambah'    => ['SupplierController', 'tambah'],
    '/admin/supplier/simpan'    => ['SupplierController', 'simpan'],
    '/admin/supplier/edit'      => ['SupplierController', 'edit'],
    '/admin/supplier/update'    => ['SupplierController', 'update'],
    '/admin/supplier/hapus'     => ['SupplierController', 'hapus'],

    // PEMASOKAN — PETUGAS
    '/pemasokan'          => ['PemasokanController', 'index'],
    '/pemasokan/detail'   => ['PemasokanController', 'detail'],

    // PEMASOKAN — ADMIN
    '/admin/pemasokan'          => ['PemasokanController', 'indexAdmin'],
    '/admin/pemasokan/detail'   => ['PemasokanController', 'detailAdmin'],
    '/admin/pemasokan/tambah'   => ['PemasokanController', 'tambah'],
    '/admin/pemasokan/simpan'   => ['PemasokanController', 'simpan'],
    '/admin/pemasokan/hapus'    => ['PemasokanController', 'hapus'],


    // LAPORAN — ADMIN
    '/admin/laporan'      => ['LaporanController', 'index'],
];

// ─── Dispatch ──────────────────────────────────────────────────
if (array_key_exists($path, $routes)) {
    [$controllerName, $method] = $routes[$path];

    $controller = new $controllerName();
    $controller->$method();

} else {
    http_response_code(404);
    echo '<h1>404 — Halaman tidak ditemukan</h1>';
    echo '<a href="' . BASE_URL . '/login">Kembali ke Login</a>';
}