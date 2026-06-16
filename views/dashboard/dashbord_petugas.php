<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Dashboard — StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
<body>
<div class="layout">

    <?php $aktif = 'dashboard'; require_once ROOT . '/views/layout/sidebar.php'; ?>

    <main class="main-content">
        <?php require_once ROOT . '/views/layout/topbar.php'; ?>

        <div class="content">

            <div class="page-header">
                <div class="page-title">
                    <h1>Dashboard</h1>
                    <p>Ringkasan sistem manajemen stok</p>
                </div>
            </div>

            <!-- STAT CARDS -->
            <div class="cards">
                <div class="stat-card">
                    <p>Total Supplier</p>
                    <h2><?= $data['total_supplier'] ?? 5 ?></h2>
                    <span>Supplier terdaftar</span>
                </div>
                <div class="stat-card">
                    <p>Total Barang</p>
                    <h2><?= $data['total_barang'] ?? 14 ?></h2>
                    <span>Item produk</span>
                </div>
                <div class="stat-card">
                    <p>Total Pemasokan</p>
                    <h2><?= $data['total_pemasokan'] ?? 0 ?></h2>
                    <span>Transaksi tercatat</span>
                </div>
                <div class="stat-card">
                    <p>Stok Rendah</p>
                    <h2><?= count($data['stok_rendah'] ?? []) ?></h2>
                    <span>Perlu restock</span>
                </div>
            </div>

            <!-- BOTTOM GRID -->
            <div class="bottom">
                <div class="box">
                    <h3>Barang Stok Rendah</h3>
                    <div class="table-wrap">
                        <table class="table table-dashboard">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($data['stok_rendah'])): ?>
                                <?php foreach ($data['stok_rendah'] as $barang): ?>
                                    <tr>
                                        <td>
                                            <?= htmlspecialchars($barang['nama'] ?? $barang['nama_barang'] ?? '-') ?>
                                        </td>

                                        <td>
                                            <?= (int)($barang['stok'] ?? 0) ?>
                                            <?= htmlspecialchars($barang['satuan'] ?? '') ?>
                                        </td>

                                        <td>
                                            <?php if ((int)($barang['stok'] ?? 0) <= 0): ?>
                                                <span class="badge habis">Habis</span>
                                            <?php else: ?>
                                                <span class="badge stok-rendah">Stok Rendah</span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <a 
                                                href="<?= BASE_URL ?>/admin/barang/detail?id=<?= (int)($barang['id'] ?? 0) ?>" 
                                                class="link"
                                            >
                                                Kelola
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" style="text-align:center">
                                        Tidak ada stok rendah
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        </table>
                    </div>
                </div>

                <div class="box">
            <h3>Pemasokan Terbaru</h3>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($data['pemasokan_terbaru'])): ?>
                        <?php foreach ($data['pemasokan_terbaru'] as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['tanggal'] ?? '-') ?></td>
                                <td>
                                    <?= htmlspecialchars($p['kode_barang'] ?? '-') ?> -
                                    <?= htmlspecialchars($p['nama_barang'] ?? '-') ?>
                                </td>
                                <td>
                                    <?= (int)($p['jumlah'] ?? 0) ?>
                                    <?= htmlspecialchars($p['satuan'] ?? '') ?>
                                </td>
                                <td>
                                    <a href="<?= BASE_URL ?>/pemasokan/detail?id=<?= (int)$p['id'] ?>" class="link">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align:center;" class="empty">
                                Belum ada pemasokan
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
    </main>
</div>
<?php require_once ROOT . '/views/layout/footer.php'; ?>
</body>
</html>
