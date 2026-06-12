<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Detail Pemasokan — Admin StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
<body>
<div class="layout">

    <?php $aktif = 'pemasokan'; require_once ROOT . '/views/layout/sidebar_admin.php'; ?>

    <main class="main-content">
        <?php require_once ROOT . '/views/layout/topbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <div class="breadcrumb">
                        <a href="<?= BASE_URL ?>/admin/pemasokan">Pemasokan</a>
                        <span>›</span>
                        <span>Detail Pemasokan</span>
                    </div>
                    <h1>Detail Pemasokan</h1>
                    <p>Informasi lengkap transaksi pemasokan</p>
                </div>
                <div style="display:flex;gap:10px;">
                    <a href="#modal-hapus" class="btn-delete">Hapus</a>
                    <a href="<?= BASE_URL ?>/admin/pemasokan" class="btn gray">Kembali</a>
                </div>
            </div>

            <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;padding:14px 18px;font-size:13px;color:#1e40af;margin-bottom:16px;">
                ℹ️ Transaksi pemasokan tidak dapat diedit. Jika ada kesalahan, hapus dan buat transaksi baru.
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>PMK-<?= str_pad($data['pemasokan']['id'] ?? 1, 3, '0', STR_PAD_LEFT) ?> — <?= htmlspecialchars($data['pemasokan']['tanggal'] ?? '10 Mei 2026') ?></h3>
                    <p>Dicatat oleh Admin pada <?= htmlspecialchars($data['pemasokan']['tanggal'] ?? '10 Mei 2026') ?></p>
                </div>
                <div class="card-body">
                    <div class="detail-grid">
                        <div>
                            <div class="detail-row">
                                <span class="detail-label">ID Pemasokan</span>
                                <span class="detail-value">PMK-<?= str_pad($data['pemasokan']['id'] ?? 1, 3, '0', STR_PAD_LEFT) ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Tanggal</span>
                                <span class="detail-value"><?= htmlspecialchars($data['pemasokan']['tanggal'] ?? '10 Mei 2026') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Supplier</span>
                                <span class="detail-value"><?= htmlspecialchars($data['pemasokan']['nama_supplier'] ?? 'PT Maju Tak Gentar') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Petugas Pencatat</span>
                                <span class="detail-value">Admin</span>
                            </div>
                        </div>
                        <div>
                            <div class="detail-row">
                                <span class="detail-label">Barang</span>
                                <span class="detail-value"><?= htmlspecialchars($data['pemasokan']['nama_barang'] ?? 'Beras Premium 5kg') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Jumlah</span>
                                <span class="detail-value"><?= htmlspecialchars($data['pemasokan']['jumlah'] ?? 100) ?> pcs</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Harga Beli Satuan</span>
                                <span class="detail-value">Rp <?= number_format((float)($data['pemasokan']['harga_beli'] ?? 65000), 0, ',', '.') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Total Harga</span>
                                <span class="detail-value" style="font-size:16px;font-weight:800;color:#F45B18;">
                                    Rp <?= number_format((float)($data['pemasokan']['total'] ?? 6500000), 0, ',', '.') ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top:16px;padding-top:16px;border-top:1px solid #f1f5f9;">
                        <div class="detail-row" style="border:none;padding:0;">
                            <span class="detail-label">Catatan</span>
                            <span class="detail-value" style="color:#6b7280;font-style:italic;">
                                <?= htmlspecialchars($data['pemasokan']['catatan'] ?? 'Restock bulanan.') ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<div class="modal" id="modal-hapus">
    <div class="modal-box">
        <a href="#" class="close">&times;</a>
        <h2>Hapus Pemasokan</h2>
        <p>Yakin ingin menghapus transaksi pemasokan <strong>PMK-<?= str_pad($data['pemasokan']['id'] ?? 1, 3, '0', STR_PAD_LEFT) ?></strong>? Stok barang terkait tidak akan dikurangi otomatis.</p>
        <div style="display:flex;gap:10px;justify-content:flex-end;">
            <a href="#" class="btn-secondary">Batal</a>
            <a href="<?= BASE_URL ?>/admin/pemasokan/hapus?id=<?= (int)($data['pemasokan']['id'] ?? 1) ?>" class="btn-delete" style="padding:9px 16px;">Ya, Hapus</a>
        </div>
    </div>
</div>

<?php require_once ROOT . '/views/layout/footer.php'; ?>
</body>
</html>
