<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Detail Supplier — StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
<body>
<div class="layout">

    <?php $aktif = 'supplier'; require_once ROOT . '/views/layout/sidebar.php'; ?>

    <main class="main-content">
        <?php require_once ROOT . '/views/layout/topbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <div class="breadcrumb">
                        <a href="<?= BASE_URL ?>/supplier">Data Supplier</a>
                        <span>›</span>
                        <span>Detail Supplier</span>
                    </div>
                    <h1>Detail Supplier</h1>
                    <p>Informasi lengkap data supplier</p>
                </div>
                <a href="<?= BASE_URL ?>/supplier" class="btn gray">Kembali</a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3><?= htmlspecialchars($data['supplier']['perusahaan'] ?? '-') ?></h3>
                    <p>Informasi kontak dan detail perusahaan</p>
                </div>
                <div class="card-body">
                    <div class="detail-grid">
                        <div>
                            <div class="detail-row">
                                <span class="detail-label">Nama Penanggung Jawab</span>
                                <span class="detail-value"><?= htmlspecialchars($data['supplier']['nama'] ?? '-') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Nama Perusahaan</span>
                                <span class="detail-value"><?= htmlspecialchars($data['supplier']['perusahaan'] ?? '-') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Kategori Produk</span>
                                <span class="detail-value"><?= htmlspecialchars($data['supplier']['kategori'] ?? '-') ?></span>
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
                                <span class="detail-value"><?= htmlspecialchars($data['supplier']['telepon'] ?? '-') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Email</span>
                                <span class="detail-value"><?= htmlspecialchars($data['supplier']['email'] ?? '-') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Alamat</span>
                                <span class="detail-value"><?= htmlspecialchars($data['supplier']['alamat'] ?? '-') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Catatan</span>
                                <span class="detail-value"><?= htmlspecialchars($data['supplier']['catatan'] ?? '-') ?></span>
                            </div>
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