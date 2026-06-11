<?php
require_once ROOT . '/controllers/AuthController.php';

// ─── Barang Controller ──────────────────────────────────────────
class BarangController {

    // ── PETUGAS: List barang ──
    public function index() {
        AuthController::cekLogin();
        $search = trim($_GET['search'] ?? '');
        $kategori = trim($_GET['kategori'] ?? '');
        $data['barang'] = Barang::getAll($search, $kategori);
        $data['kategori_list'] = Barang::getKategoriList();
        $data['search'] = $search;
        $data['kategori'] = $kategori;
        require_once ROOT . '/views/barang/index.php';
    }

    // ── PETUGAS: Detail barang ──
    public function detail() {
        AuthController::cekLogin();
        $id = $_GET['id'] ?? null;
        $data['barang'] = Barang::findById($id);
        if (!$data['barang']) {
            header('Location: ' . BASE_URL . '/barang');
            exit;
        }
        require_once ROOT . '/views/barang/detail.php';
    }

    // ── ADMIN: List barang ──
    public function indexAdmin() {
        AuthController::cekAdmin();
        $search = trim($_GET['search'] ?? '');
        $kategori = trim($_GET['kategori'] ?? '');
        $data['barang']    = Barang::getAll($search, $kategori);
        $data['kategori_list'] = Barang::getKategoriList();
        $data['search'] = $search;
        $data['kategori'] = $kategori;
        $data['suppliers'] = Supplier::getAll();
        $data['stock_out'] = StockOut::getAll();
        $data['stock_out_error'] = $_SESSION['stock_out_error'] ?? '';
        $data['stock_out_success'] = $_SESSION['stock_out_success'] ?? '';
        unset($_SESSION['stock_out_error'], $_SESSION['stock_out_success']);
        require_once ROOT . '/views/admin/barang/index.php';
    }

    // ── ADMIN: Detail barang ──
    public function detailAdmin() {
        AuthController::cekAdmin();
        $id = $_GET['id'] ?? null;
        $data['barang'] = Barang::findById($id);
        if (!$data['barang']) {
            header('Location: ' . BASE_URL . '/admin/barang');
            exit;
        }
        require_once ROOT . '/views/admin/barang/detail.php';
    }

    // ── ADMIN: Form tambah barang ──
    public function tambah() {
        AuthController::cekAdmin();
        $data['suppliers'] = Supplier::getAll();
        require_once ROOT . '/views/admin/barang/tambah.php';
    }

    // ── ADMIN: Simpan barang baru ──
    public function simpan() {
        AuthController::cekAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/barang/tambah');
            exit;
        }
        Barang::create([
            'kode'         => $_POST['kode'] ?? '',
            'nama'         => $_POST['nama'] ?? '',
            'kategori'     => $_POST['kategori'] ?? '',
            'merek'        => $_POST['merek'] ?? '',
            'supplier_id'  => $_POST['supplier_id'] ?? null,
            'stok'         => $_POST['stok'] ?? 0,
            'satuan'       => $_POST['satuan'] ?? '',
            'stok_minimum' => $_POST['stok_minimum'] ?? 0,
            'harga_beli'   => $_POST['harga_beli'] ?? 0,
            'harga_jual'   => $_POST['harga_jual'] ?? 0,
            'deskripsi'    => $_POST['deskripsi'] ?? '',
        ]);
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

    // ── ADMIN: Update barang ──
    public function update() {
        AuthController::cekAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/barang');
            exit;
        }
        $id = $_POST['id'];
        Barang::update($id, [
            'kode'         => $_POST['kode'] ?? '',
            'nama'         => $_POST['nama'] ?? '',
            'kategori'     => $_POST['kategori'] ?? '',
            'merek'        => $_POST['merek'] ?? '',
            'supplier_id'  => $_POST['supplier_id'] ?? null,
            'stok'         => $_POST['stok'] ?? 0,
            'satuan'       => $_POST['satuan'] ?? '',
            'stok_minimum' => $_POST['stok_minimum'] ?? 0,
            'harga_beli'   => $_POST['harga_beli'] ?? 0,
            'harga_jual'   => $_POST['harga_jual'] ?? 0,
            'deskripsi'    => $_POST['deskripsi'] ?? '',
        ]);
        header('Location: ' . BASE_URL . '/admin/barang');
        exit;
    }

    // ── ADMIN: Hapus barang ──
    public function hapus() {
        AuthController::cekAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) Barang::delete($id);
        header('Location: ' . BASE_URL . '/admin/barang');
        exit;
    }

    // ── ADMIN: Simpan stock out dari halaman Data Barang ──
    public function simpanStockOut() {
        AuthController::cekAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/barang');
            exit;
        }

        try {
            StockOut::create([
                'barang_id' => $_POST['barang_id'] ?? null,
                'jumlah'    => $_POST['jumlah'] ?? 0,
                'tanggal'   => $_POST['tanggal'] ?? date('Y-m-d'),
                'tujuan'    => $_POST['tujuan'] ?? '',
                'catatan'   => $_POST['catatan'] ?? '',
                'user_id'   => $_SESSION['user_id'] ?? null,
            ]);
            $_SESSION['stock_out_success'] = 'Stock out berhasil disimpan dan stok barang sudah dikurangi.';
        } catch (Throwable $e) {
            $_SESSION['stock_out_error'] = $e->getMessage();
        }

        header('Location: ' . BASE_URL . '/admin/barang');
        exit;
    }

    // ── ADMIN: Hapus riwayat stock out dari halaman Data Barang ──
    public function hapusStockOut() {
        AuthController::cekAdmin();
        $id = $_GET['id'] ?? null;
        try {
            if ($id) {
                StockOut::delete($id);
                $_SESSION['stock_out_success'] = 'Data stock out dihapus dan stok barang dikembalikan.';
            }
        } catch (Throwable $e) {
            $_SESSION['stock_out_error'] = $e->getMessage();
        }
        header('Location: ' . BASE_URL . '/admin/barang');
        exit;
    }

}
