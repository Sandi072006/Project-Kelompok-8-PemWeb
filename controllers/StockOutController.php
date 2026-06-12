<?php
require_once ROOT . '/controllers/AuthController.php';

class StockOutController {

    public function indexAdmin() {
        AuthController::cekAdmin();
        $data['stock_out'] = StockOut::getAll();
        require_once ROOT . '/views/admin/stock_out/index.php';
    }

    public function tambah() {
        AuthController::cekAdmin();
        $data['barang'] = Barang::getAll();
        require_once ROOT . '/views/admin/stock_out/tambah.php';
    }

    public function simpan() {
        AuthController::cekAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/stock-out/tambah');
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
            header('Location: ' . BASE_URL . '/admin/stock-out');
            exit;
        } catch (Throwable $e) {
            $data['error'] = $e->getMessage();
            $data['barang'] = Barang::getAll();
            require_once ROOT . '/views/admin/stock_out/tambah.php';
        }
    }

    public function hapus() {
        AuthController::cekAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) StockOut::delete($id);
        header('Location: ' . BASE_URL . '/admin/stock-out');
        exit;
    }
}
