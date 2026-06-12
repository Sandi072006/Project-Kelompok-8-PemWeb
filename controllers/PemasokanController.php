<?php
require_once ROOT . '/controllers/AuthController.php';

// ─── Pemasokan Controller ───────────────────────────────────────
class PemasokanController {

    // ── PETUGAS: List pemasokan ──
    public function index() {
        AuthController::cekLogin();
        $keyword = $_GET['q'] ?? '';
        $supplierId = $_GET['supplier_id'] ?? '';
        $data['filters'] = ['q' => $keyword, 'supplier_id' => $supplierId];
        $data['supplier'] = Supplier::getAll();
        $data['pemasokan'] = Pemasokan::search($keyword, $supplierId);
        require_once ROOT . '/views/pemasokan/index.php';
    }

    // ── PETUGAS: Detail pemasokan ──
    public function detail() {
        AuthController::cekLogin();
        $id = $_GET['id'] ?? null;
        $data['pemasokan'] = Pemasokan::findById($id);
        if (!$data['pemasokan']) {
            header('Location: ' . BASE_URL . '/pemasokan');
            exit;
        }
        require_once ROOT . '/views/pemasokan/detail.php';
    }

    // ── ADMIN: List pemasokan ──
    public function indexAdmin() {
        AuthController::cekAdmin();
        $keyword = $_GET['q'] ?? '';
        $supplierId = $_GET['supplier_id'] ?? '';
        $data['filters'] = ['q' => $keyword, 'supplier_id' => $supplierId];
        $data['supplier'] = Supplier::getAll();
        $data['pemasokan'] = Pemasokan::search($keyword, $supplierId);
        require_once ROOT . '/views/admin/pemasokan/index.php';
    }

    // ── ADMIN: Detail pemasokan ──
    public function detailAdmin() {
        AuthController::cekAdmin();
        $id = $_GET['id'] ?? null;
        $data['pemasokan'] = Pemasokan::findById($id);
        if (!$data['pemasokan']) {
            header('Location: ' . BASE_URL . '/admin/pemasokan');
            exit;
        }
        require_once ROOT . '/views/admin/pemasokan/detail.php';
    }

    // ── ADMIN: Form tambah pemasokan ──
    public function tambah() {
        AuthController::cekAdmin();
        $data['supplier'] = Supplier::getAktif();
        $data['barang']   = Barang::getAll();
        require_once ROOT . '/views/admin/pemasokan/tambah.php';
    }

    // ── ADMIN: Simpan pemasokan baru ──
    public function simpan() {
        AuthController::cekAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/pemasokan/tambah');
            exit;
        }
        Pemasokan::create([
            'tanggal'     => $_POST['tanggal'] ?? date('Y-m-d'),
            'supplier_id' => $_POST['supplier_id'] ?? null,
            'barang_id'   => $_POST['barang_id'] ?? null,
            'jumlah'      => $_POST['jumlah'] ?? 0,
            'harga_beli'  => $_POST['harga_beli'] ?? 0,
            'catatan'     => $_POST['catatan'] ?? '',
            'user_id'     => $_SESSION['user_id'],
        ]);
        header('Location: ' . BASE_URL . '/admin/pemasokan');
        exit;
    }

    // ── ADMIN: Hapus pemasokan ──
    // (pemasokan tidak bisa diedit, hanya bisa dihapus)
    public function hapus() {
        AuthController::cekAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) Pemasokan::delete($id);
        header('Location: ' . BASE_URL . '/admin/pemasokan');
        exit;
    }
}
