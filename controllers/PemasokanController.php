<?php
require_once ROOT . '/controllers/AuthController.php';
class PemasokanController {

    public function index() {
        AuthController::cekLogin();
        $keyword = isset($_GET['q']) ? $_GET['q'] : '';
        $supplierId = isset($_GET['supplier_id']) ? $_GET['supplier_id'] : '';
        $data['filters'] = ['q' => $keyword, 'supplier_id' => $supplierId];
        $data['supplier'] = Supplier::getAll();
        $data['pemasokan'] = Pemasokan::search($keyword, $supplierId);
        require_once ROOT . '/views/pemasokan/index.php';
    }
    public function detail() {
        AuthController::cekLogin();
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $data['pemasokan'] = Pemasokan::findById($id);
        if (!$data['pemasokan']) {
            header('Location: ' . BASE_URL . '/pemasokan');
            exit;
        }
        require_once ROOT . '/views/pemasokan/detail.php';
    }
    public function tambah() {
        AuthController::cekLogin();
        $data['supplier'] = Supplier::getAktif();
        $data['barang']   = Barang::getAll(); // which now filters by aktif
        require_once ROOT . '/views/pemasokan/tambah.php';
    }

    
    public function simpan() {
        AuthController::cekLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/pemasokan/tambah');
            exit;
        }
        
        
        $tanggal     = isset($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d');
        $supplier_id = isset($_POST['supplier_id']) ? $_POST['supplier_id'] : null;
        $barang_id   = isset($_POST['barang_id']) ? $_POST['barang_id'] : null;
        $jumlah      = isset($_POST['jumlah']) ? $_POST['jumlah'] : 0;
        $harga_beli  = isset($_POST['harga_beli']) ? $_POST['harga_beli'] : 0;
        $catatan     = isset($_POST['catatan']) ? $_POST['catatan'] : '';
        $user_id     = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        
        Pemasokan::create([
            'tanggal'     => $tanggal,
            'supplier_id' => $supplier_id,
            'barang_id'   => $barang_id,
            'jumlah'      => $jumlah,
            'harga_beli'  => $harga_beli,
            'catatan'     => $catatan,
            'user_id'     => $user_id,
        ]);
        header('Location: ' . BASE_URL . '/pemasokan');
        exit;
    }
    public function batalkan() {
        AuthController::cekLogin();
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        
        if ($id) {
            Pemasokan::cancel($id, $_SESSION['user_id']);
        }
        header('Location: ' . BASE_URL . '/pemasokan');
        exit;
    }
    public function indexAdmin() {
        AuthController::cekAdmin();
        $keyword = $_GET['q'] ?? '';
        $supplierId = $_GET['supplier_id'] ?? '';
        $data['filters'] = ['q' => $keyword, 'supplier_id' => $supplierId];
        $data['supplier'] = Supplier::getAll();
        $data['pemasokan'] = Pemasokan::search($keyword, $supplierId);
        require_once ROOT . '/views/admin/pemasokan/index.php';
    }
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
    public function batalkanAdmin() {
        AuthController::cekAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) {
            Pemasokan::cancel($id, $_SESSION['user_id']);
        }
        header('Location: ' . BASE_URL . '/admin/pemasokan');
        exit;
    }
}
