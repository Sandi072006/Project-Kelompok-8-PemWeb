<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Detail Pemasokan — StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
<body>
<div class="layout">

    <?php $aktif = 'pemasokan'; require_once ROOT . '/views/layout/sidebar.php'; ?>

    <main class="main-content">
        <?php require_once ROOT . '/views/layout/topbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <div class="breadcrumb">
                        <a href="<?= BASE_URL ?>/pemasokan">Pemasokan</a>
                        <span>›</span>
                        <span>Detail Pemasokan</span>
                    </div>
                    <h1>Detail Pemasokan</h1>
                    <p>Informasi lengkap transaksi pemasokan</p>
                </div>
                <a href="<?= BASE_URL ?>/pemasokan" class="btn gray">Kembali</a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>PMK-001 — 10 Mei 2026</h3>
                    <p>Dicatat oleh Admin pada 10 Mei 2026, 09.30</p>
                </div>
                <div class="card-body">
                    <div class="detail-grid">
                        <div>
                            <div class="detail-row"><span class="detail-label">ID Pemasokan</span><span class="detail-value">PMK-001</span></div>
                            <div class="detail-row"><span class="detail-label">Tanggal</span><span class="detail-value">10 Mei 2026</span></div>
                            <div class="detail-row"><span class="detail-label">Supplier</span><span class="detail-value">PT Maju Tak Gentar</span></div>
                            <div class="detail-row"><span class="detail-label">Petugas Pencatat</span><span class="detail-value">Admin</span></div>
                        </div>
                        <div>
                            <div class="detail-row"><span class="detail-label">Barang</span><span class="detail-value">Beras Premium 5kg (BRG001)</span></div>
                            <div class="detail-row"><span class="detail-label">Jumlah</span><span class="detail-value">100 pcs</span></div>
                            <div class="detail-row"><span class="detail-label">Harga Beli Satuan</span><span class="detail-value">Rp 65.000</span></div>
                            <div class="detail-row"><span class="detail-label">Total Harga</span><span class="detail-value" style="font-size:16px;font-weight:800;color:#F45B18;">Rp 6.500.000</span></div>
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
