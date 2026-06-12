<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Manajemen Supplier — Admin StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
<body>
<div class="layout">

    <?php $aktif = 'supplier'; require_once ROOT . '/views/layout/sidebar_admin.php'; ?>

    <main class="main-content">
        <?php require_once ROOT . '/views/layout/topbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h1>Manajemen Supplier</h1>
                    <p>Kelola data supplier pemasok</p>
                </div>
                <div class="qa-grid">
                    <a href="<?= BASE_URL ?>/admin/supplier/tambah" class="qa-card">
                        <div class="qa-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="7" width="20" height="14" rx="2"/>
                                <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                                <line x1="12" y1="12" x2="12" y2="16"/>
                                <line x1="10" y1="14" x2="14" y2="14"/>
                            </svg>
                        </div>
                        <span>Tambah Supplier</span>
                    </a>
                </div>
            </div>

            <div class="card">
                <form class="toolbar" method="GET" action="<?= BASE_URL ?>/admin/supplier">
                    <div class="search-box">
                        <input type="text" name="q" class="search-input" placeholder="Cari supplier, perusahaan, telepon, atau email..." value="<?= htmlspecialchars($data['filters']['q'] ?? '') ?>" />
                    </div>
                    <select name="status" class="select-filter" data-table-filter="5" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="aktif" <?= (($data['filters']['status'] ?? '') === 'aktif') ? 'selected' : '' ?>>Aktif</option>
                        <option value="nonaktif" <?= (($data['filters']['status'] ?? '') === 'nonaktif') ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                    <button type="submit" class="btn-primary" style="padding:10px 14px;border:0;border-radius:10px;cursor:pointer;">Cari</button>
                    <?php if (!empty($data['filters']['q']) || !empty($data['filters']['status'])): ?>
                        <a href="<?= BASE_URL ?>/admin/supplier" class="btn-secondary" style="padding:10px 14px;border-radius:10px;text-decoration:none;">Reset</a>
                    <?php endif; ?>
                </form>

                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Supplier</th>
                                <th>Perusahaan</th>
                                <th>Kontak</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($data['supplier'])): ?>
                            <?php foreach ($data['supplier'] as $supplier): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($supplier['nama']) ?></strong></td>
                                <td><?= htmlspecialchars($supplier['perusahaan'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($supplier['telepon'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($supplier['email'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($supplier['alamat'] ?? '-') ?></td>
                                <td>
                                    <?php if (($supplier['status'] ?? '') === 'aktif'): ?>
                                        <img src="<?= BASE_URL ?>/assets/img/check.svg" class="status-icon" alt="Aktif" title="Aktif">
                                    <?php else: ?>
                                        <img src="<?= BASE_URL ?>/assets/img/wrong.svg" class="status-icon" alt="Nonaktif" title="Nonaktif">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="display:flex;gap:6px;">
                                        <a href="<?= BASE_URL ?>/admin/supplier/detail?id=<?= (int)$supplier['id'] ?>" class="link">Lihat</a>
                                        <a href="<?= BASE_URL ?>/admin/supplier/edit?id=<?= (int)$supplier['id'] ?>" class="btn-edit">Edit</a>
                                        <a href="#modal-hapus-<?= (int)$supplier['id'] ?>" class="btn-delete">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" style="text-align:center;">Tidak ada data supplier</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<?php if (!empty($data['supplier'])): ?>
    <?php foreach ($data['supplier'] as $supplier): ?>
    <div class="modal" id="modal-hapus-<?= (int)$supplier['id'] ?>">
        <div class="modal-box">
            <a href="#" class="close">&times;</a>
            <h2>Hapus Supplier</h2>
            <p>Yakin ingin menghapus <strong><?= htmlspecialchars($supplier['nama']) ?></strong>? Tindakan ini tidak bisa dibatalkan.</p>
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <a href="#" class="btn-secondary">Batal</a>
                <a href="<?= BASE_URL ?>/admin/supplier/hapus?id=<?= (int)$supplier['id'] ?>" class="btn-delete" style="padding:9px 16px;">Ya, Hapus</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php require_once ROOT . '/views/layout/footer.php'; ?>
</body>
</html>