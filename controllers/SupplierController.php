<?php
require_once ROOT . '/controllers/AuthController.php';

// ─── Supplier Controller ────────────────────────────────────────
class SupplierController {

    // ── PETUGAS: List supplier ──
    public function index() {
        AuthController::cekLogin();
        $keyword = $_GET['q'] ?? '';
        $status = $_GET['status'] ?? '';
        $data['filters'] = ['q' => $keyword, 'status' => $status];
        $data['supplier'] = Supplier::search($keyword, $status);
        require_once ROOT . '/views/supplier/index.php';
    }

    // ── PETUGAS: Detail supplier ──
    public function detail() {
        AuthController::cekLogin();
        $id = $_GET['id'] ?? null;
        $data['supplier']  = Supplier::findById($id);
        $data['pemasokan'] = Pemasokan::getBySupplier($id);
        if (!$data['supplier']) {
            header('Location: ' . BASE_URL . '/supplier');
            exit;
        }
        require_once ROOT . '/views/supplier/detail.php';
    }

    // ── ADMIN: List supplier ──
    public function indexAdmin() {
        AuthController::cekAdmin();
        $keyword = $_GET['q'] ?? '';
        $status = $_GET['status'] ?? '';
        $data['filters'] = ['q' => $keyword, 'status' => $status];
        $data['supplier'] = Supplier::search($keyword, $status);
        require_once ROOT . '/views/admin/supplier/index.php';
    }

    // ── ADMIN: Detail supplier ──
    public function detailAdmin() {
        AuthController::cekAdmin();
        $id = $_GET['id'] ?? null;
        $data['supplier']  = Supplier::findById($id);
        $data['pemasokan'] = Pemasokan::getBySupplier($id);
        if (!$data['supplier']) {
            header('Location: ' . BASE_URL . '/admin/supplier');
            exit;
        }
        require_once ROOT . '/views/admin/supplier/detail.php';
    }

    // ── ADMIN: Form tambah supplier ──
    public function tambah() {
        AuthController::cekAdmin();
        require_once ROOT . '/views/admin/supplier/tambah.php';
    }

    // ── ADMIN: Simpan supplier baru ──
    public function simpan() {
        AuthController::cekAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/supplier/tambah');
            exit;
        }
        Supplier::create([
            'nama'       => $_POST['nama'] ?? '',
            'perusahaan' => $_POST['perusahaan'] ?? '',
            'telepon'    => $_POST['telepon'] ?? '',
            'email'      => $_POST['email'] ?? '',
            'alamat'     => $_POST['alamat'] ?? '',
            'kategori'   => $_POST['kategori'] ?? '',
            'status'     => $_POST['status'] ?? 'aktif',
            'catatan'    => $_POST['catatan'] ?? '',
        ]);
        header('Location: ' . BASE_URL . '/admin/supplier');
        exit;
    }

    // ── ADMIN: Form edit supplier ──
    public function edit() {
        AuthController::cekAdmin();
        $id = $_GET['id'] ?? null;
        $data['supplier'] = Supplier::findById($id);
        if (!$data['supplier']) {
            header('Location: ' . BASE_URL . '/admin/supplier');
            exit;
        }
        require_once ROOT . '/views/admin/supplier/edit.php';
    }

    // ── ADMIN: Update supplier ──
    public function update() {
        AuthController::cekAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/supplier');
            exit;
        }
        $id = $_POST['id'];
        Supplier::update($id, [
            'nama'       => $_POST['nama'] ?? '',
            'perusahaan' => $_POST['perusahaan'] ?? '',
            'telepon'    => $_POST['telepon'] ?? '',
            'email'      => $_POST['email'] ?? '',
            'alamat'     => $_POST['alamat'] ?? '',
            'kategori'   => $_POST['kategori'] ?? '',
            'status'     => $_POST['status'] ?? 'aktif',
            'catatan'    => $_POST['catatan'] ?? '',
        ]);
        header('Location: ' . BASE_URL . '/admin/supplier');
        exit;
    }

    // ── ADMIN: Hapus supplier ──
    public function hapus() {
        AuthController::cekAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) Supplier::delete($id);
        header('Location: ' . BASE_URL . '/admin/supplier');
        exit;
    }
}
