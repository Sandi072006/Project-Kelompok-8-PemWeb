<?php
require_once ROOT . '/controllers/AuthController.php';

// ─── Dashboard Controller ───────────────────────────────────────
class DashboardController {

    // ── Dashboard Petugas Gudang ──
    public function petugas() {
        AuthController::cekLogin();

        $data = [
            'total_supplier'  => Supplier::count(),
            'total_barang'    => Barang::count(),
            'total_pemasokan' => Pemasokan::count(),
            'stok_rendah'     => Barang::getStokRendah(),
        ];

        require_once ROOT . '/views/dashboard/dashbord_petugas.php';
    }

    // ── Dashboard Admin ──
    public function admin() {
        AuthController::cekAdmin();

        $data = [
            'total_supplier'  => Supplier::count(),
            'total_barang'    => Barang::count(),
            'total_pemasokan' => Pemasokan::count(),
            'stok_rendah'     => Barang::getStokRendah(),
        ];

        require_once ROOT . '/views/admin/dashboard/index.php';
    }
}