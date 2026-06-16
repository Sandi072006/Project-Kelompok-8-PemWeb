<?php
require_once ROOT . '/controllers/AuthController.php';

class SupplierController {

    public function index() {
        AuthController::cekLogin();
        
        $keyword = isset($_GET['q']) ? $_GET['q'] : '';
        $status  = isset($_GET['status']) ? $_GET['status'] : '';
        
        $data['filters'] = ['q' => $keyword, 'status' => $status];
        
        $data['supplier'] = Supplier::search($keyword, $status);
        
        require_once ROOT . '/views/supplier/index.php';
    }

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

    public function indexAdmin() {
        AuthController::cekAdmin();
        $keyword = $_GET['q'] ?? '';
        $status = $_GET['status'] ?? '';
        $data['filters'] = ['q' => $keyword, 'status' => $status];
        $data['supplier'] = Supplier::search($keyword, $status);
        $data['supplier_success'] = $_SESSION['supplier_success'] ?? '';
        $data['supplier_error'] = $_SESSION['supplier_error'] ?? '';
        unset($_SESSION['supplier_success'], $_SESSION['supplier_error']);
        require_once ROOT . '/views/admin/supplier/index.php';
    }

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

    public function tambah() {
        AuthController::cekAdmin();
        require_once ROOT . '/views/admin/supplier/tambah.php';
    }

    public function simpan() {
        AuthController::cekAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/supplier/tambah');
            exit;
        }
        
        $nama       = isset($_POST['nama']) ? $_POST['nama'] : '';
        $perusahaan = isset($_POST['perusahaan']) ? $_POST['perusahaan'] : '';
        $telepon    = isset($_POST['telepon']) ? $_POST['telepon'] : '';
        $email      = isset($_POST['email']) ? $_POST['email'] : '';
        $alamat     = isset($_POST['alamat']) ? $_POST['alamat'] : '';
        $kategori   = isset($_POST['kategori']) ? $_POST['kategori'] : '';
        $status     = isset($_POST['status']) ? $_POST['status'] : 'aktif';
        $catatan    = isset($_POST['catatan']) ? $_POST['catatan'] : '';

        Supplier::create([
            'nama'       => $nama,
            'perusahaan' => $perusahaan,
            'telepon'    => $telepon,
            'email'      => $email,
            'alamat'     => $alamat,
            'kategori'   => $kategori,
            'status'     => $status,
            'catatan'    => $catatan,
        ]);
        header('Location: ' . BASE_URL . '/admin/supplier');
        exit;
    }

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

    public function update() {
        AuthController::cekAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/supplier');
            exit;
        }
        
        $id = $_POST['id'];
        
        $nama       = isset($_POST['nama']) ? $_POST['nama'] : '';
        $perusahaan = isset($_POST['perusahaan']) ? $_POST['perusahaan'] : '';
        $telepon    = isset($_POST['telepon']) ? $_POST['telepon'] : '';
        $email      = isset($_POST['email']) ? $_POST['email'] : '';
        $alamat     = isset($_POST['alamat']) ? $_POST['alamat'] : '';
        $kategori   = isset($_POST['kategori']) ? $_POST['kategori'] : '';
        $status     = isset($_POST['status']) ? $_POST['status'] : 'aktif';
        $catatan    = isset($_POST['catatan']) ? $_POST['catatan'] : '';

        Supplier::update($id, [
            'nama'       => $nama,
            'perusahaan' => $perusahaan,
            'telepon'    => $telepon,
            'email'      => $email,
            'alamat'     => $alamat,
            'kategori'   => $kategori,
            'status'     => $status,
            'catatan'    => $catatan,
        ]);
        header('Location: ' . BASE_URL . '/admin/supplier');
        exit;
    }

    public function hapus() {
        AuthController::cekAdmin();
        $id = $_GET['id'] ?? null;
        try {
            if ($id) {
                Supplier::delete($id);
                $_SESSION['supplier_success'] = 'Supplier berhasil dinonaktifkan.';
            }
        } catch (Throwable $e) {
            $_SESSION['supplier_error'] = 'Supplier gagal dinonaktifkan: ' . $e->getMessage();
        }
        header('Location: ' . BASE_URL . '/admin/supplier');
        exit;
    }
}
