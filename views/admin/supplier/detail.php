<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Detail Supplier — Admin StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
<body>
<div class="layout">

    <?php $aktif = 'supplier'; require_once ROOT . '/views/layout/sidebar_admin.php'; ?>

    <main class="main-content">
        <?php require_once ROOT . '/views/layout/topbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <div class="breadcrumb">
                        <a href="<?= BASE_URL ?>/admin/supplier">Supplier</a>
                        <span>›</span>
                        <span>Detail Supplier</span>
                    </div>
                    <h1>Detail Supplier</h1>
                    <p>Informasi lengkap data supplier</p>
                </div>
                <div style="display:flex;gap:10px;">
                    <a href="<?= BASE_URL ?>/admin/supplier/edit?id=<?= (int)($data['supplier']['id'] ?? 1) ?>" class="btn-edit">Edit</a>
                    <a href="#modal-hapus" class="btn-delete">Hapus</a>
                    <a href="<?= BASE_URL ?>/admin/supplier" class="btn gray">Kembali</a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3><?= htmlspecialchars($data['supplier']['perusahaan'] ?? 'PT Maju Tak Gentar') ?></h3>
                    <p>Terakhir diperbarui: 09 Mei 2026</p>
                </div>
                <div class="card-body">
                    <div class="detail-grid">
                        <div>
                            <div class="detail-row">
                                <span class="detail-label">Nama Penanggung Jawab</span>
                                <span class="detail-value"><?= htmlspecialchars($data['supplier']['nama'] ?? 'Sandi Zuliansyah') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Nama Perusahaan</span>
                                <span class="detail-value"><?= htmlspecialchars($data['supplier']['perusahaan'] ?? 'PT Maju Tak Gentar') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Kategori Produk</span>
                                <span class="detail-value"><?= htmlspecialchars($data['supplier']['kategori'] ?? 'Makanan') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Status</span>
                                <span class="detail-value">
                                    <?php if (($data['supplier']['status'] ?? 'aktif') === 'aktif'): ?>
                                        <img src="<?= BASE_URL ?>/assets/img/check.svg" style="width:22px;height:22px;" alt="Aktif" title="Aktif">
                                    <?php else: ?>
                                        <img src="<?= BASE_URL ?>/assets/img/wrong.svg" style="width:22px;height:22px;" alt="Nonaktif" title="Nonaktif">
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                        <div>
                            <div class="detail-row">
                                <span class="detail-label">Nomor Telepon</span>
                                <span class="detail-value"><?= htmlspecialchars($data['supplier']['telepon'] ?? '081234567890') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Email</span>
                                <span class="detail-value"><?= htmlspecialchars($data['supplier']['email'] ?? 'sandi@majutakgentar.com') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Alamat</span>
                                <span class="detail-value"><?= htmlspecialchars($data['supplier']['alamat'] ?? 'Jl. Merdeka No.1, Jakarta') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Catatan</span>
                                <span class="detail-value"><?= htmlspecialchars($data['supplier']['catatan'] ?? 'Supplier utama untuk bahan makanan pokok.') ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-top:16px;">
                <div class="card-header">
                    <h3>Riwayat Pemasokan</h3>
                    <p>Transaksi pemasokan dari <?= htmlspecialchars($data['supplier']['perusahaan'] ?? 'supplier ini') ?></p>
                </div>
                <div class="card-body">
                    <p class="empty">Belum ada riwayat pemasokan dari supplier ini</p>
                </div>
            </div>
        </div>
    </main>
</div>

<div class="modal" id="modal-hapus">
    <div class="modal-box">
        <a href="#" class="close">&times;</a>
        <h2>Hapus Supplier</h2>
        <p>Yakin ingin menghapus <strong><?= htmlspecialchars($data['supplier']['perusahaan'] ?? 'PT Maju Tak Gentar') ?></strong>? Tindakan ini tidak bisa dibatalkan.</p>
        <div style="display:flex;gap:10px;justify-content:flex-end;">
            <a href="#" class="btn-secondary">Batal</a>
            <a href="<?= BASE_URL ?>/admin/supplier/hapus?id=<?= (int)($data['supplier']['id'] ?? 1) ?>" class="btn-delete" style="padding:9px 16px;">Ya, Hapus</a>
        </div>
    </div>
</div>

<?php require_once ROOT . '/views/layout/footer.php'; ?>
</body>
</html>