<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Tambah Stock Out — Admin StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
<body>
<div class="layout">
    <?php $aktif = 'stock_out'; require_once ROOT . '/views/layout/sidebar_admin.php'; ?>

    <main class="main-content">
        <?php require_once ROOT . '/views/layout/topbar.php'; ?>
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h1>Tambah Stock Out</h1>
                    <p>Kurangi stok barang saat barang keluar dari gudang</p>
                </div>
            </div>

            <div class="card">
                <?php if (!empty($data['error'])): ?>
                    <div style="padding:12px;border-radius:10px;background:#fee2e2;color:#991b1b;margin-bottom:14px;">
                        <?= htmlspecialchars($data['error']) ?>
                    </div>
                <?php endif; ?>

                <form action="<?= BASE_URL ?>/admin/stock-out/simpan" method="POST" class="form-grid">
                    <div class="form-group">
                        <label>Barang</label>
                        <select name="barang_id" required>
                            <option value="">Pilih barang</option>
                            <?php foreach (($data['barang'] ?? []) as $barang): ?>
                                <option value="<?= (int)$barang['id'] ?>">
                                    <?= htmlspecialchars($barang['kode'] . ' - ' . $barang['nama'] . ' | Stok: ' . $barang['stok'] . ' ' . ($barang['satuan'] ?? '')) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Jumlah Keluar</label>
                        <input type="number" name="jumlah" min="1" required>
                    </div>

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Tujuan / Keterangan Keluar</label>
                        <input type="text" name="tujuan" placeholder="Contoh: Penjualan, rusak, retur, dipakai toko">
                    </div>

                    <div class="form-group" style="grid-column:1/-1;">
                        <label>Catatan</label>
                        <textarea name="catatan" rows="4" placeholder="Catatan tambahan"></textarea>
                    </div>

                    <div style="grid-column:1/-1;display:flex;gap:10px;justify-content:flex-end;">
                        <a href="<?= BASE_URL ?>/admin/stock-out" class="btn-secondary">Batal</a>
                        <button type="submit" class="btn-primary">Simpan Stock Out</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
<?php require_once ROOT . '/views/layout/footer.php'; ?>
</body>
</html>
