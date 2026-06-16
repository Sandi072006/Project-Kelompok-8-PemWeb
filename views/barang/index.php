<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Data Barang — StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
<body>
<div class="layout">

    <?php $aktif = 'barang'; require_once ROOT . '/views/layout/sidebar.php'; ?>

    <main class="main-content">
        <?php require_once ROOT . '/views/layout/topbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h1>Data Barang</h1>
                    <p>Lihat data barang supermarket</p>
                </div>
            </div>

            <div class="card">
                <?php if (!empty($data['stock_out_success'])): ?>
                    <div style="padding:12px;border-radius:10px;background:#dcfce7;color:#166534;margin-bottom:14px;">
                        <?= htmlspecialchars($data['stock_out_success']) ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($data['stock_out_error'])): ?>
                    <div style="padding:12px;border-radius:10px;background:#fee2e2;color:#991b1b;margin-bottom:14px;">
                        <?= htmlspecialchars($data['stock_out_error']) ?>
                    </div>
                <?php endif; ?>

                <form class="toolbar" method="GET" action="<?= BASE_URL ?>/barang">
                    <div class="search-box">
                        <input type="text" name="search" class="search-input" value="<?= htmlspecialchars($data['search'] ?? '') ?>" placeholder="Cari barang, kategori, merek, atau supplier..." />
                    </div>
                    <select name="kategori" class="select-filter" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        <?php foreach (($data['kategori_list'] ?? []) as $kat): ?>
                            <option value="<?= htmlspecialchars($kat) ?>" <?= (($data['kategori'] ?? '') === $kat) ? 'selected' : '' ?>><?= htmlspecialchars($kat) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn-primary" style="padding:9px 14px;">Cari</button>
                    <?php if (!empty($data['search']) || !empty($data['kategori'])): ?>
                        <a href="<?= BASE_URL ?>/barang" class="btn-secondary">Reset</a>
                    <?php endif; ?>
                </form>

                <div class="table-wrap">
                    <table class="table" style="min-width:980px;">
                        <thead>
                            <tr>
                                <th>Kode</th><th>Nama Barang</th><th>Kategori</th><th>Merek</th><th>Supplier</th><th>Stok</th><th>Harga Beli</th><th>Harga Jual</th><th>Status</th><th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($data['barang'])): ?>
                            <?php foreach ($data['barang'] as $barang): ?>
                            <tr>
                                <td style="padding:12px 12px;font-size:12.5px;"><?= htmlspecialchars($barang['kode'] ?? '') ?></td>
                                <td style="padding:12px 12px;font-size:12.5px;"><?= htmlspecialchars($barang['nama'] ?? '') ?></td>
                                <td style="padding:12px 12px;font-size:12.5px;"><?= htmlspecialchars($barang['kategori'] ?? '') ?></td>
                                <td style="padding:12px 12px;font-size:12.5px;"><?= htmlspecialchars($barang['merek'] ?? '') ?></td>
                                <td style="padding:12px 12px;font-size:12.5px;"><?= htmlspecialchars($barang['nama_supplier'] ?? '-') ?></td>
                                <td style="padding:12px 12px;font-size:12.5px;white-space:nowrap;"><?= $barang['stok'] ?> <?= htmlspecialchars($barang['satuan'] ?? '') ?></td>
                                <td style="padding:12px 12px;font-size:12.5px;white-space:nowrap;">Rp <?= number_format((float)$barang['harga_beli'], 0, ',', '.') ?></td>
                                <td style="padding:12px 12px;font-size:12.5px;white-space:nowrap;">Rp <?= number_format((float)$barang['harga_jual'], 0, ',', '.') ?></td>
                                <td style="padding:12px 12px;">
                                    <?php if ($barang['stok'] <= 0): ?>
                                        <img src="<?= BASE_URL ?>/assets/img/wrong.svg" class="status-icon" alt="Habis" title="Habis">
                                    <?php elseif ($barang['stok'] <= ($barang['stok_minimum'] ?? 0)): ?>
                                        <img src="<?= BASE_URL ?>/assets/img/warning.svg" class="status-icon" alt="Stok Rendah" title="Stok Rendah">
                                    <?php else: ?>
                                        <img src="<?= BASE_URL ?>/assets/img/check.svg" class="status-icon" alt="Tersedia" title="Tersedia">
                                    <?php endif; ?>
                                </td>
                                <td style="padding:12px 12px;">
                                    <div style="display:flex;gap:5px;align-items:center;">
                                        <a href="<?= BASE_URL ?>/barang/detail?id=<?= (int)$barang['id'] ?>" class="link" style="font-size:12.5px;">Lihat</a>
                                        <a href="#modal-stockout-<?= (int)$barang['id'] ?>" class="btn-secondary" style="font-size:12px;padding:5px 10px;white-space:nowrap;">Kurangi Stok</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="10" style="text-align:center;">Data tidak ditemukan</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card stockout-card">
                <div class="stockout-header">
                    <div>
                        <h2>Riwayat Stock Out</h2>
                        <p>Catatan barang yang keluar langsung dari fitur Data Barang</p>
                    </div>
                </div>
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
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($data['stock_out'])): ?>
                            <?php foreach ($data['stock_out'] as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['kode'] ?? '') ?></td>
                                <td><?= htmlspecialchars(date('d-m-Y', strtotime($row['tanggal']))) ?></td>
                                <td><?= htmlspecialchars(($row['kode_barang'] ?? '-') . ' - ' . ($row['nama_barang'] ?? '-')) ?></td>
                                <td><?= (int)$row['jumlah'] ?> <?= htmlspecialchars($row['satuan'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['tujuan'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($row['catatan'] ?? '-') ?></td>
                                <td>
                                    <?php if (($row['status'] ?? 'aktif') === 'dibatalkan'): ?>
                                        <span style="color:#991b1b;background:#fee2e2;padding:4px 8px;border-radius:4px;font-size:12px;">Dibatalkan</span>
                                    <?php else: ?>
                                        <span style="color:#166534;background:#dcfce7;padding:4px 8px;border-radius:4px;font-size:12px;">Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (($row['status'] ?? 'aktif') === 'aktif'): ?>
                                        <a href="<?= BASE_URL ?>/barang/stock-out/batalkan?id=<?= (int)$row['id'] ?>" class="btn-delete" onclick="return confirm('Batalkan data stock out ini? Stok barang akan dikembalikan.')">Batalkan</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="8" style="text-align:center;">Belum ada data stock out</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</div>

<?php if (!empty($data['barang'])): ?>
    <?php foreach ($data['barang'] as $barang): ?>
    <div class="modal" id="modal-stockout-<?= (int)$barang['id'] ?>">
        <div class="modal-box">
            <a href="#" class="close">&times;</a>
            <h2>Kurangi Stok Barang</h2>
            <p>Kurangi stok untuk <strong><?= htmlspecialchars($barang['nama']) ?></strong>. Stok saat ini: <strong><?= (int)$barang['stok'] ?> <?= htmlspecialchars($barang['satuan'] ?? '') ?></strong>.</p>
            <form action="<?= BASE_URL ?>/barang/stock-out/simpan" method="POST" class="form-grid" style="margin-top:14px;">
                <input type="hidden" name="barang_id" value="<?= (int)$barang['id'] ?>">
                <div class="form-group">
                    <label>Jumlah Keluar</label>
                    <input type="number" name="jumlah" min="1" max="<?= max(0, (int)$barang['stok']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label>Tujuan / Alasan Keluar</label>
                    <input type="text" name="tujuan" placeholder="Contoh: Penjualan, rusak, retur, dipakai toko">
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label>Catatan</label>
                    <textarea name="catatan" rows="3" placeholder="Catatan tambahan"></textarea>
                </div>
                <div style="grid-column:1/-1;display:flex;gap:10px;justify-content:flex-end;">
                    <a href="#" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary">Simpan Stok Berkurang</button>
                </div>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php require_once ROOT . '/views/layout/footer.php'; ?>
</body>
</html>
