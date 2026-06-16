<?php
require_once ROOT . '/controllers/AuthController.php';

class DashboardController {
    public function petugas() {
        AuthController::cekLogin();
        $data = [
            'total_supplier'     => Supplier::count(),
            'total_barang'       => Barang::count(),
            'total_pemasokan'    => Pemasokan::count(),
            'stok_rendah'        => Barang::getStokRendah(),
            'pemasokan_terbaru'  => Pemasokan::getTerbaru(5),
        ];

        require_once ROOT . '/views/dashboard/dashbord_petugas.php';
    }

    public function admin() {
        AuthController::cekAdmin();
        $data = [
            'total_supplier'     => Supplier::count(),
            'total_barang'       => Barang::count(),
            'total_pemasokan'    => Pemasokan::count(),
            'stok_rendah'        => Barang::getStokRendah(),
            'pemasokan_terbaru'  => Pemasokan::getTerbaru(5),
        ];

        require_once ROOT . '/views/admin/dashboard/index.php';
    }
}
