<?php
require_once ROOT . '/controllers/AuthController.php';

class BarangController {

    public function index() {
        AuthController::cekLogin();
        $search   = isset($_GET['search']) ? trim($_GET['search']) : '';
        $kategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';
        
        $data['barang']        = Barang::getAll($search, $kategori);
        $data['kategori_list'] = Barang::getKategoriList();
        $data['search']        = $search;
        $data['kategori']      = $kategori;
        $data['stock_out'] = StockOut::getAll();
        
        $data['stock_out_error']   = isset($_SESSION['stock_out_error']) ? $_SESSION['stock_out_error'] : '';
        $data['stock_out_success'] = isset($_SESSION['stock_out_success']) ? $_SESSION['stock_out_success'] : '';
        unset($_SESSION['stock_out_error'], $_SESSION['stock_out_success']);
        
        require_once ROOT . '/views/barang/index.php';
    }

    public function detail() {
        AuthController::cekLogin();
        $id = $_GET['id'] ?? null;
        $data['barang'] = Barang::findById($id);
        if (!$data['barang']) {
            header('Location: ' . BASE_URL . '/barang');
            exit;
        }
        $data['riwayat_masuk']  = Pemasokan::getByBarang($id, 5);
        $data['riwayat_keluar'] = StockOut::getByBarang($id, 5);
        require_once ROOT . '/views/barang/detail.php';
    }

    public function indexAdmin() {
        AuthController::cekAdmin();
        $search   = isset($_GET['search']) ? trim($_GET['search']) : '';
        $kategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';
        
        $data['barang']        = Barang::getAll($search, $kategori);
        $data['kategori_list'] = Barang::getKategoriList();
        $data['search']        = $search;
        $data['kategori']      = $kategori;
        
        $data['suppliers'] = Supplier::getAll();
        $data['stock_out'] = StockOut::getAll();
        
        $data['stock_out_error']   = isset($_SESSION['stock_out_error']) ? $_SESSION['stock_out_error'] : '';
        $data['stock_out_success'] = isset($_SESSION['stock_out_success']) ? $_SESSION['stock_out_success'] : '';
        unset($_SESSION['stock_out_error'], $_SESSION['stock_out_success']);
        
        require_once ROOT . '/views/admin/barang/index.php';
    }

    public function detailAdmin() {
        AuthController::cekAdmin();
        $id = $_GET['id'] ?? null;
        $data['barang'] = Barang::findById($id);
        if (!$data['barang']) {
            header('Location: ' . BASE_URL . '/admin/barang');
            exit;
        }
        $data['riwayat_masuk']  = Pemasokan::getByBarang($id, 5);
        $data['riwayat_keluar'] = StockOut::getByBarang($id, 5);
        require_once ROOT . '/views/admin/barang/detail.php';
    }

    public function tambah() {
        AuthController::cekAdmin();
        $data['suppliers'] = Supplier::getAll();
        $data['kode_otomatis'] = Barang::generateKodeBarang();
        require_once ROOT . '/views/admin/barang/tambah.php';
    }
    public function simpan() {
        AuthController::cekAdmin();
    
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/barang/tambah');
            exit;
        }
    
        $nama         = isset($_POST['nama']) ? trim($_POST['nama']) : '';
        $kategori     = isset($_POST['kategori']) ? trim($_POST['kategori']) : '';
        $merek        = isset($_POST['merek']) ? trim($_POST['merek']) : '';
        $supplier_id  = isset($_POST['supplier_id']) ? $_POST['supplier_id'] : null;
        $satuan       = isset($_POST['satuan']) ? trim($_POST['satuan']) : '';
        $stok_minimum = isset($_POST['stok_minimum']) ? (int)$_POST['stok_minimum'] : 0;
        $harga_beli   = isset($_POST['harga_beli']) ? $_POST['harga_beli'] : 0;
        $harga_jual   = isset($_POST['harga_jual']) ? $_POST['harga_jual'] : 0;
        $deskripsi    = isset($_POST['deskripsi']) ? trim($_POST['deskripsi']) : '';
    
        try {
            Barang::create([
                'nama'         => $nama,
                'kategori'     => $kategori,
                'merek'        => $merek,
                'supplier_id'  => $supplier_id,
                'satuan'       => $satuan,
                'stok_minimum' => $stok_minimum,
                'harga_beli'   => $harga_beli,
                'harga_jual'   => $harga_jual,
                'deskripsi'    => $deskripsi,
            ]);
    
            $_SESSION['stock_out_success'] = 'Barang berhasil ditambahkan.';
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $_SESSION['stock_out_error'] = 'Gagal menyimpan: kode barang otomatis sudah digunakan. Coba simpan ulang.';
            } else {
                $_SESSION['stock_out_error'] = 'Terjadi kesalahan sistem: ' . $e->getMessage();
            }
        } catch (Throwable $e) {
            $_SESSION['stock_out_error'] = 'Terjadi kesalahan: ' . $e->getMessage();
        }
    
        header('Location: ' . BASE_URL . '/admin/barang');
        exit;
    }

    // ── ADMIN: Form edit barang ──
    public function edit() {
        AuthController::cekAdmin();
        $id = $_GET['id'] ?? null;
        $data['barang']    = Barang::findById($id);
        $data['suppliers'] = Supplier::getAll();
        if (!$data['barang']) {
            header('Location: ' . BASE_URL . '/admin/barang');
            exit;
        }
        require_once ROOT . '/views/admin/barang/edit.php';
    }

    public function update() {
        AuthController::cekAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/barang');
            exit;
        }
        $id = $_POST['id'];
        
        $kode         = isset($_POST['kode']) ? $_POST['kode'] : '';
        $nama         = isset($_POST['nama']) ? $_POST['nama'] : '';
        $kategori     = isset($_POST['kategori']) ? $_POST['kategori'] : '';
        $merek        = isset($_POST['merek']) ? $_POST['merek'] : '';
        $supplier_id  = isset($_POST['supplier_id']) ? $_POST['supplier_id'] : null;
        $satuan       = isset($_POST['satuan']) ? $_POST['satuan'] : '';
        $stok_minimum = isset($_POST['stok_minimum']) ? $_POST['stok_minimum'] : 0;
        $harga_beli   = isset($_POST['harga_beli']) ? $_POST['harga_beli'] : 0;
        $harga_jual   = isset($_POST['harga_jual']) ? $_POST['harga_jual'] : 0;
        $deskripsi    = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';

        try {
            Barang::update($id, [
                'kode'         => $kode,
                'nama'         => $nama,
                'kategori'     => $kategori,
                'merek'        => $merek,
                'supplier_id'  => $supplier_id,
                'satuan'       => $satuan,
                'stok_minimum' => $stok_minimum,
                'harga_beli'   => $harga_beli,
                'harga_jual'   => $harga_jual,
                'deskripsi'    => $deskripsi,
            ]);
            $_SESSION['stock_out_success'] = 'Barang berhasil diupdate.';
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $_SESSION['stock_out_error'] = 'Gagal menyimpan: Kode barang "' . htmlspecialchars($kode) . '" sudah digunakan oleh barang lain.';
            } else {
                $_SESSION['stock_out_error'] = 'Terjadi kesalahan sistem: ' . $e->getMessage();
            }
        } catch (Throwable $e) {
            $_SESSION['stock_out_error'] = 'Terjadi kesalahan: ' . $e->getMessage();
        }

        header('Location: ' . BASE_URL . '/admin/barang');
        exit;
    }

    public function hapus() {
        AuthController::cekAdmin();
        $id = $_GET['id'] ?? null;
        try {
            if ($id) {
                Barang::delete($id);
                $_SESSION['stock_out_success'] = 'Barang berhasil dinonaktifkan.';
            }
        } catch (Throwable $e) {
            $_SESSION['stock_out_error'] = 'Barang gagal dinonaktifkan: ' . $e->getMessage();
        }
        header('Location: ' . BASE_URL . '/admin/barang');
        exit;
    }
    public function simpanStockOut() {
        AuthController::cekAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/barang');
            exit;
        }

        try {
            $barang_id = isset($_POST['barang_id']) ? $_POST['barang_id'] : null;
            $jumlah    = isset($_POST['jumlah']) ? $_POST['jumlah'] : 0;
            $tanggal   = isset($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d');
            $tujuan    = isset($_POST['tujuan']) ? $_POST['tujuan'] : '';
            $catatan   = isset($_POST['catatan']) ? $_POST['catatan'] : '';
            $user_id   = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

            StockOut::create([
                'barang_id' => $barang_id,
                'jumlah'    => $jumlah,
                'tanggal'   => $tanggal,
                'tujuan'    => $tujuan,
                'catatan'   => $catatan,
                'user_id'   => $user_id,
            ]);
            $_SESSION['stock_out_success'] = 'Stock out berhasil disimpan dan stok barang sudah dikurangi.';
        } catch (Throwable $e) {
            $_SESSION['stock_out_error'] = $e->getMessage();
        }

        header('Location: ' . BASE_URL . '/admin/barang');
        exit;
    }

    public function batalkanStockOut() {
        AuthController::cekAdmin();
        $id = $_GET['id'] ?? null;
        try {
            if ($id) {
                StockOut::cancel($id, $_SESSION['user_id'] ?? null);
                $_SESSION['stock_out_success'] = 'Data stock out dibatalkan dan stok barang dikembalikan.';
            }
        } catch (Throwable $e) {
            $_SESSION['stock_out_error'] = $e->getMessage();
        }
        header('Location: ' . BASE_URL . '/admin/barang');
        exit;
    }

    public function simpanStockOutPetugas() {
        AuthController::cekLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/barang');
            exit;
        }
        try {
            $barang_id = isset($_POST['barang_id']) ? $_POST['barang_id'] : null;
            $jumlah    = isset($_POST['jumlah']) ? $_POST['jumlah'] : 0;
            $tanggal   = isset($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d');
            $tujuan    = isset($_POST['tujuan']) ? $_POST['tujuan'] : '';
            $catatan   = isset($_POST['catatan']) ? $_POST['catatan'] : '';
            $user_id   = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
            StockOut::create([
                'barang_id' => $barang_id,
                'jumlah'    => $jumlah,
                'tanggal'   => $tanggal,
                'tujuan'    => $tujuan,
                'catatan'   => $catatan,
                'user_id'   => $user_id,
            ]);
            $_SESSION['stock_out_success'] = 'Stock out berhasil disimpan dan stok barang sudah dikurangi.';
        } catch (Throwable $e) {
            $_SESSION['stock_out_error'] = $e->getMessage();
        }
        header('Location: ' . BASE_URL . '/barang');
        exit;
    }
    public function batalkanStockOutPetugas() {
        AuthController::cekLogin();
        $id = $_GET['id'] ?? null;
        try {
            if ($id) {
                StockOut::cancel($id, $_SESSION['user_id'] ?? null);
                $_SESSION['stock_out_success'] = 'Data stock out dibatalkan dan stok barang dikembalikan.';
            }
        } catch (Throwable $e) {
            $_SESSION['stock_out_error'] = $e->getMessage();
        }
        header('Location: ' . BASE_URL . '/barang');
        exit;
    }

}
