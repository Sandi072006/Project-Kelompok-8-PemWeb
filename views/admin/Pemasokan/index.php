<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Manajemen Pemasokan — Admin StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
<body>
<div class="layout">

    <?php $aktif = 'pemasokan'; require_once ROOT . '/views/layout/sidebar_admin.php'; ?>

    <main class="main-content">
        <?php require_once ROOT . '/views/layout/topbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h1>Manajemen Pemasokan</h1>
                    <p>Kelola data pemasokan barang</p>
                </div>
                <div class="qa-grid">
                    <a href="<?= BASE_URL ?>/admin/pemasokan/tambah" class="qa-card">
                        <div class="qa-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14"/>
                            </svg>
                        </div>
                        <span>Tambah Pemasokan</span>
                    </a>
                </div>
            </div>

            <div class="card">
                <form class="toolbar" method="GET" action="<?= BASE_URL ?>/admin/pemasokan">
                    <div class="search-box">
                        <input type="text" name="q" class="search-input" placeholder="Cari kode, tanggal, supplier, barang, atau catatan..." value="<?= htmlspecialchars($data['filters']['q'] ?? '') ?>" />
                    </div>
                    <select name="supplier_id" class="select-filter" data-table-filter="1" onchange="this.form.submit()">
                        <option value="">Semua Supplier</option>
                        <?php foreach (($data['supplier'] ?? []) as $supplier): ?>
                            <option value="<?= (int)$supplier['id'] ?>" <?= ((string)($data['filters']['supplier_id'] ?? '') === (string)$supplier['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($supplier['perusahaan'] ?: $supplier['nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn-primary" style="padding:10px 14px;border:0;border-radius:10px;cursor:pointer;">Cari</button>
                    <?php if (!empty($data['filters']['q']) || !empty($data['filters']['supplier_id'])): ?>
                        <a href="<?= BASE_URL ?>/admin/pemasokan" class="btn-secondary" style="padding:10px 14px;border-radius:10px;text-decoration:none;">Reset</a>
                    <?php endif; ?>
                </form>

                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Supplier</th>
                                <th>Barang</th>
                                <th>Jumlah</th>
                                <th>Catatan</th>
                                <th>Petugas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($data['pemasokan'])): ?>
                            <?php foreach ($data['pemasokan'] as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['tanggal'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($p['nama_supplier'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($p['nama_barang'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($p['jumlah'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($p['catatan'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($p['petugas'] ?? 'Admin') ?></td>
                                <td>
                                    <div style="display:flex;gap:6px;">
                                        <a href="<?= BASE_URL ?>/admin/pemasokan/detail?id=<?= (int)$p['id'] ?>" class="link">Lihat</a>
                                        <a href="#modal-hapus-<?= (int)$p['id'] ?>" class="btn-delete">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" style="text-align:center;" class="empty">Belum ada data pemasokan</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<?php if (!empty($data['pemasokan'])): ?>
    <?php foreach ($data['pemasokan'] as $p): ?>
    <div class="modal" id="modal-hapus-<?= (int)$p['id'] ?>">
        <div class="modal-box">
            <a href="#" class="close">&times;</a>
            <h2>Hapus Pemasokan</h2>
            <p>Yakin ingin menghapus transaksi pemasokan ini? Stok barang tidak akan dikurangi otomatis.</p>
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <a href="#" class="btn-secondary">Batal</a>
                <a href="<?= BASE_URL ?>/admin/pemasokan/hapus?id=<?= (int)$p['id'] ?>" class="btn-delete" style="padding:9px 16px;">Ya, Hapus</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php require_once ROOT . '/views/layout/footer.php'; ?>
</body>
</html>