<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Supplier — StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
<body>
<div class="layout">

    <?php $aktif = 'supplier'; require_once ROOT . '/views/layout/sidebar.php'; ?>

    <main class="main-content">
        <?php require_once ROOT . '/views/layout/topbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h1>Data Supplier</h1>
                    <p>Lihat data supplier pemasok</p>
                </div>
            </div>

            <div class="card">
               <form method="GET" action="<?= BASE_URL ?>/supplier" class="toolbar">
    <div class="search-box">
        <input 
            type="text" 
            name="q"
            class="search-input" 
            placeholder="Cari supplier, perusahaan, atau email..."
            value="<?= htmlspecialchars($data['filters']['q'] ?? '') ?>"
        />
    </div>

    <select name="status" class="select-filter" onchange="this.form.submit()">
        <option value="">Semua Status</option>
        <option value="aktif" <?= (($data['filters']['status'] ?? '') === 'aktif') ? 'selected' : '' ?>>
            Aktif
        </option>
        <option value="nonaktif" <?= (($data['filters']['status'] ?? '') === 'nonaktif') ? 'selected' : '' ?>>
            Nonaktif
        </option>
    </select>

    <button type="submit" class="btn-primary">Cari</button>
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
                                <td><strong><?= htmlspecialchars($supplier['nama'] ?? '') ?></strong></td>
                                <td><?= htmlspecialchars($supplier['perusahaan'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($supplier['telepon'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($supplier['email'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($supplier['alamat'] ?? '-') ?></td>
                                <td>
                                    <?php if (strtolower($supplier['status'] ?? '') === 'aktif'): ?>
                                        <img src="<?= BASE_URL ?>/assets/img/check.svg" class="status-icon" alt="Aktif" title="Aktif">
                                    <?php else: ?>
                                        <img src="<?= BASE_URL ?>/assets/img/wrong.svg" class="status-icon" alt="Nonaktif" title="Nonaktif">
                                    <?php endif; ?>
                                </td>
                                <td><a href="<?= BASE_URL ?>/supplier/detail?id=<?= (int)$supplier['id'] ?>" class="link">Lihat</a></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" style="text-align:center;" class="empty">Data supplier tidak ditemukan</td></tr>
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