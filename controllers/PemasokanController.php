<?php
require_once ROOT . '/controllers/AuthController.php';

// ─── Pemasokan Controller ───────────────────────────────────────
class PemasokanController {

    public function index() {
        AuthController::cekLogin();
        $keyword = $_GET['q'] ?? '';
        $supplierId = $_GET['supplier_id'] ?? '';
        $data['filters'] = ['q' => $keyword, 'supplier_id' => $supplierId];
        $data['supplier'] = Supplier::getAll();
        $data['pemasokan'] = Pemasokan::search($keyword, $supplierId);
        require_once ROOT . '/views/pemasokan/index.php';
    }

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
    public function hapus() {
        AuthController::cekAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) Pemasokan::delete($id);
        header('Location: ' . BASE_URL . '/admin/pemasokan');
        exit;
    }
}
