<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Detail Barang — Admin StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
<body>
<div class="layout">

    <?php $aktif = 'barang'; require_once ROOT . '/views/layout/sidebar_admin.php'; ?>

    <main class="main-content">
        <?php require_once ROOT . '/views/layout/topbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <div class="breadcrumb">
                        <a href="<?= BASE_URL ?>/admin/barang">Data Barang</a>
                        <span>›</span>
                        <span>Detail Barang</span>
                    </div>
                    <h1>Detail Barang</h1>
                    <p>Informasi lengkap data barang</p>
                </div>
                <div style="display:flex;gap:10px;">
                    <a href="<?= BASE_URL ?>/admin/barang/edit?id=<?= (int)($data['barang']['id'] ?? 1) ?>" class="btn-edit">Edit</a>
                    <a href="#modal-hapus" class="btn-delete">Hapus</a>
                    <a href="<?= BASE_URL ?>/admin/barang" class="btn gray">Kembali</a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3><?= htmlspecialchars($data['barang']['kode'] ?? 'BRG001') ?> — <?= htmlspecialchars($data['barang']['nama'] ?? 'Beras Premium 5kg') ?></h3>
                    <p>Terakhir diperbarui: 09 Mei 2026</p>
                </div>
                <div class="card-body">
                    <div class="detail-grid">
                        <div>
                            <div class="detail-row">
                                <span class="detail-label">Kode Barang</span>
                                <span class="detail-value"><?= htmlspecialchars($data['barang']['kode'] ?? 'BRG001') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Nama Barang</span>
                                <span class="detail-value"><?= htmlspecialchars($data['barang']['nama'] ?? 'Beras Premium 5kg') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Kategori</span>
                                <span class="detail-value"><?= htmlspecialchars($data['barang']['kategori'] ?? 'Makanan') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Merek</span>
                                <span class="detail-value"><?= htmlspecialchars($data['barang']['merek'] ?? 'Ramos') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Supplier</span>
                                <span class="detail-value"><?= htmlspecialchars($data['barang']['nama_supplier'] ?? 'PT Maju Tak Gentar') ?></span>
                            </div>
                        </div>
                        <div>
                            <div class="detail-row">
                                <span class="detail-label">Stok Saat Ini</span>
                                <span class="detail-value"><?= ($data['barang']['stok'] ?? 150) ?> <?= htmlspecialchars($data['barang']['satuan'] ?? 'pcs') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Stok Minimum</span>
                                <span class="detail-value"><?= ($data['barang']['stok_minimum'] ?? 20) ?> <?= htmlspecialchars($data['barang']['satuan'] ?? 'pcs') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Harga Beli</span>
                                <span class="detail-value">Rp <?= number_format((float)($data['barang']['harga_beli'] ?? 65000), 0, ',', '.') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Harga Jual</span>
                                <span class="detail-value">Rp <?= number_format((float)($data['barang']['harga_jual'] ?? 75000), 0, ',', '.') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Status</span>
                                <span class="detail-value">
                                    <?php $stok = $data['barang']['stok'] ?? 150; $min = $data['barang']['stok_minimum'] ?? 0; ?>
                                    <?php if ($stok <= 0): ?>
                                        <img src="<?= BASE_URL ?>/assets/img/wrong.svg" style="width:22px;height:22px;" alt="Habis">
                                    <?php elseif ($stok <= $min): ?>
                                        <img src="<?= BASE_URL ?>/assets/img/warning.svg" style="width:22px;height:22px;" alt="Stok Rendah">
                                    <?php else: ?>
                                        <img src="<?= BASE_URL ?>/assets/img/check.svg" style="width:22px;height:22px;" alt="Tersedia">
                                    <?php endif; ?>
                                </span>
                            </div>
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
        <h2>Hapus Barang</h2>
        <p>Yakin ingin menghapus <strong><?= htmlspecialchars($data['barang']['nama'] ?? 'Beras Premium 5kg') ?></strong>? Tindakan ini tidak bisa dibatalkan.</p>
        <div style="display:flex;gap:10px;justify-content:flex-end;">
            <a href="#" class="btn-secondary">Batal</a>
            <a href="<?= BASE_URL ?>/admin/barang/hapus?id=<?= (int)($data['barang']['id'] ?? 1) ?>" class="btn-delete" style="padding:9px 16px;">Ya, Hapus</a>
        </div>
    </div>
</div>

<?php require_once ROOT . '/views/layout/footer.php'; ?>
</body>
</html>