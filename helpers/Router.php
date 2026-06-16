<?php
// ─── Router (Penerjemah Alamat Halaman) ────────────────────────────────────────────────────

// Ambil alamat URL (URI) yang sedang dikunjungi pengguna
if (isset($_SERVER['REQUEST_URI'])) {
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
} else {
    $requestUri = '/';
}

// Ambil path folder tempat aplikasi ini dijalankan
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$basePath   = rtrim(str_replace('\\', '/', $scriptName), '/');

// Sesuaikan path jika aplikasi dijalankan di dalam sub-folder
if ($basePath !== '' && $basePath !== '/') {
    // Memastikan URI diawali dengan basePath
    if (strpos($requestUri, $basePath) === 0) {
        $path = substr($requestUri, strlen($basePath));
    } else {
        $path = $requestUri;
    }
} else {
    $path = $requestUri;
}

// Buang bagian query string (seperti ?id=1) menggunakan fungsi strtok
$path = strtok($path, '?');   

// Buang tanda garis miring (/) di akhir path
$path = rtrim($path, '/');    

// Kalau path ternyata kosong, kita anggap pengguna berada di halaman depan (/)
if ($path === '') {
    $path = '/';
}

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
    '/barang/stock-out/simpan'   => ['BarangController', 'simpanStockOutPetugas'],
    '/barang/stock-out/batalkan' => ['BarangController', 'batalkanStockOutPetugas'],

    // BARANG — ADMIN
    '/admin/barang'           => ['BarangController', 'indexAdmin'],
    '/admin/barang/detail'    => ['BarangController', 'detailAdmin'],
    '/admin/barang/tambah'    => ['BarangController', 'tambah'],
    '/admin/barang/simpan'    => ['BarangController', 'simpan'],
    '/admin/barang/edit'      => ['BarangController', 'edit'],
    '/admin/barang/update'    => ['BarangController', 'update'],
    '/admin/barang/hapus'     => ['BarangController', 'hapus'],
    '/admin/barang/stock-out/simpan' => ['BarangController', 'simpanStockOut'],
    '/admin/barang/stock-out/batalkan'  => ['BarangController', 'batalkanStockOut'],

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
    '/pemasokan/tambah'   => ['PemasokanController', 'tambah'],
    '/pemasokan/simpan'   => ['PemasokanController', 'simpan'],
    '/pemasokan/batalkan' => ['PemasokanController', 'batalkan'],

    // PEMASOKAN — ADMIN
    '/admin/pemasokan'          => ['PemasokanController', 'indexAdmin'],
    '/admin/pemasokan/detail'   => ['PemasokanController', 'detailAdmin'],
    '/admin/pemasokan/tambah'   => ['PemasokanController', 'tambahAdmin'],
    '/admin/pemasokan/simpan'   => ['PemasokanController', 'simpanAdmin'],
    '/admin/pemasokan/batalkan' => ['PemasokanController', 'batalkanAdmin'],


    // LAPORAN — ADMIN
    '/admin/laporan'      => ['LaporanController', 'index'],
];

// ─── Dispatch (Pengeksekusi Halaman) ──────────────────────────────────────────────────

// Cek apakah alamat (path) yang diminta ada di dalam array $routes di atas
if (array_key_exists($path, $routes)) {
    
    // Ambil nama controller dan nama method (fungsi) dari array routes
    $controllerName = $routes[$path][0]; // Contoh: 'AuthController'
    $method         = $routes[$path][1]; // Contoh: 'index'

    // Buat objek baru dari controller tersebut (Instansiasi)
    $controller = new $controllerName();
    
    // Jalankan fungsi (method) dari controller tersebut
    $controller->$method();

} else {
    // Kalau alamat (path) tidak ditemukan di array $routes, tampilkan halaman Error 404
    http_response_code(404);
    echo '<h1>404 — Halaman tidak ditemukan</h1>';
    echo '<a href="' . BASE_URL . '/login">Kembali ke halaman Login</a>';
}
