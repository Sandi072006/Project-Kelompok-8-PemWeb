<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Detail Barang — StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
<body>
<div class="layout">

    <?php $aktif = 'barang'; require_once ROOT . '/views/layout/sidebar.php'; ?>

    <main class="main-content">
        <?php require_once ROOT . '/views/layout/topbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <div class="breadcrumb">
                        <a href="<?= BASE_URL ?>/barang">Data Barang</a>
                        <span>›</span>
                        <span>Detail Barang</span>
                    </div>
                    <h1>Detail Barang</h1>
                    <p>Informasi lengkap data barang</p>
                </div>
                <a href="<?= BASE_URL ?>/barang" class="btn gray">Kembali</a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>BRG001 — Beras Premium 5kg</h3>
                    <p>Terakhir diperbarui: 09 Mei 2026</p>
                </div>
                <div class="card-body">
                    <div class="detail-grid">
                        <div>
                            <div class="detail-row"><span class="detail-label">Kode Barang</span><span class="detail-value">BRG001</span></div>
                            <div class="detail-row"><span class="detail-label">Nama Barang</span><span class="detail-value">Beras Premium 5kg</span></div>
                            <div class="detail-row"><span class="detail-label">Kategori</span><span class="detail-value">Makanan</span></div>
                            <div class="detail-row"><span class="detail-label">Merek</span><span class="detail-value">Ramos</span></div>
                            <div class="detail-row"><span class="detail-label">Supplier</span><span class="detail-value">PT Maju Tak Gentar</span></div>
                        </div>
                        <div>
                            <div class="detail-row"><span class="detail-label">Stok Saat Ini</span><span class="detail-value">150 pcs</span></div>
                            <div class="detail-row"><span class="detail-label">Stok Minimum</span><span class="detail-value">20 pcs</span></div>
                            <div class="detail-row"><span class="detail-label">Harga Beli</span><span class="detail-value">Rp 65.000</span></div>
                            <div class="detail-row"><span class="detail-label">Harga Jual</span><span class="detail-value">Rp 75.000</span></div>
                            <div class="detail-row"><span class="detail-label">Status</span><span class="detail-value"><img src="<?= BASE_URL ?>/assets/img/check.svg" style="width:22px;height:22px;" alt="Tersedia"></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<?php require_once ROOT . '/views/layout/footer.php'; ?>
</body>
</html>