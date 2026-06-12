<?php
require_once ROOT . '/controllers/AuthController.php';

// ─── Laporan Controller ─────────────────────────────────────────
class LaporanController {

    // ── ADMIN: Halaman laporan ──
    public function index() {
        AuthController::cekAdmin();

        $data = [
            'total_barang'      => Barang::count(),
            'total_supplier'    => Supplier::count(),
            'supplier_aktif'    => Supplier::countAktif(),
            'total_pemasokan'   => Pemasokan::count(),
            'stok_rendah'       => Barang::getStokRendah(),
            'semua_barang'      => Barang::getAll(),
            'semua_supplier'    => Supplier::getAll(),
            'semua_pemasokan'   => Pemasokan::getAll(),
        ];

        require_once ROOT . '/views/admin/laporan/laporan.php';
    }
}