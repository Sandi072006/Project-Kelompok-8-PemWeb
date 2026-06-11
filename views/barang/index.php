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
                    <table class="table" style="min-width:900px;">
                        <thead>
                            <tr>
                                <th>Kode</th><th>Nama Barang</th><th>Kategori</th><th>Merek</th><th>Supplier</th><th>Stok</th><th>Harga Beli</th><th>Harga Jual</th><th>Status</th><th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($data['barang'])): ?>
                            <?php foreach ($data['barang'] as $barang): ?>
                            <tr>
                                <td><?= htmlspecialchars($barang['kode']) ?></td>
                                <td><?= htmlspecialchars($barang['nama']) ?></td>
                                <td><?= htmlspecialchars($barang['kategori']) ?></td>
                                <td><?= htmlspecialchars($barang['merek']) ?></td>
                                <td><?= htmlspecialchars($barang['nama_supplier'] ?? '-') ?></td>
                                <td><?= (int)$barang['stok'] ?> <?= htmlspecialchars($barang['satuan'] ?? '') ?></td>
                                <td>Rp <?= number_format((float)$barang['harga_beli'], 0, ',', '.') ?></td>
                                <td>Rp <?= number_format((float)$barang['harga_jual'], 0, ',', '.') ?></td>
                                <td>
                                    <?php if ($barang['stok'] <= 0): ?>
                                        <img src="<?= BASE_URL ?>/assets/img/wrong.svg" class="status-icon" alt="Habis" title="Habis">
                                    <?php elseif ($barang['stok'] <= ($barang['stok_minimum'] ?? 0)): ?>
                                        <img src="<?= BASE_URL ?>/assets/img/warning.svg" class="status-icon" alt="Stok Rendah" title="Stok Rendah">
                                    <?php else: ?>
                                        <img src="<?= BASE_URL ?>/assets/img/check.svg" class="status-icon" alt="Tersedia" title="Tersedia">
                                    <?php endif; ?>
                                </td>
                                <td><a href="<?= BASE_URL ?>/barang/detail?id=<?= (int)$barang['id'] ?>" class="link">Lihat</a></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="10" style="text-align:center;">Data tidak ditemukan</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>            </div>
        </div>
    </main>
</div>
<?php require_once ROOT . '/views/layout/footer.php'; ?>
</body>
</html>