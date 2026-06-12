<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Stock Out — Admin StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
<body>
<div class="layout">
    <?php $aktif = 'stock_out'; require_once ROOT . '/views/layout/sidebar_admin.php'; ?>

    <main class="main-content">
        <?php require_once ROOT . '/views/layout/topbar.php'; ?>
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h1>Stock Out</h1>
                    <p>Catat barang yang keluar atau berkurang dari gudang</p>
                </div>
                <div class="qa-grid">
                    <a href="<?= BASE_URL ?>/admin/stock-out/tambah" class="qa-card">
                        <div class="qa-icon">−</div>
                        <span>Tambah Stock Out</span>
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="table-wrap">
                    <table class="table" style="min-width:900px;">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Barang</th>
                                <th>Jumlah Keluar</th>
                                <th>Tujuan</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($data['stock_out'])): ?>
                            <?php foreach ($data['stock_out'] as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['kode']) ?></td>
                                <td><?= htmlspecialchars(date('d-m-Y', strtotime($row['tanggal']))) ?></td>
                                <td><?= htmlspecialchars(($row['kode_barang'] ?? '-') . ' - ' . ($row['nama_barang'] ?? '-')) ?></td>
                                <td><?= (int)$row['jumlah'] ?> <?= htmlspecialchars($row['satuan'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['tujuan'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($row['catatan'] ?? '-') ?></td>
                                <td><a href="<?= BASE_URL ?>/admin/stock-out/hapus?id=<?= (int)$row['id'] ?>" class="btn-delete" onclick="return confirm('Hapus data stock out ini? Stok barang akan dikembalikan.')">Hapus</a></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" style="text-align:center;">Belum ada data stock out</td></tr>
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
