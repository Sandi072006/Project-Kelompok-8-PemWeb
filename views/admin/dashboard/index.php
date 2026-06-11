<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Dashboard Admin — StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
<body>
<div class="layout">

    <?php $aktif = 'dashboard'; require_once ROOT . '/views/layout/sidebar_admin.php'; ?>

    <main class="main-content">
        <?php require_once ROOT . '/views/layout/topbar.php'; ?>

        <div class="content">

            <div class="page-header">
                <div class="page-title">
                    <h1>Dashboard</h1>
                    <p>Ringkasan sistem manajemen stok — Admin</p>
                </div>
                <div class="qa-grid">
                    <a href="<?= BASE_URL ?>/admin/barang/tambah" class="qa-card">
                        <div class="qa-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                                <line x1="12" y1="22" x2="12" y2="12"/>
                                <line x1="12" y1="12" x2="3.27" y2="6.96"/>
                                <line x1="12" y1="12" x2="20.73" y2="6.96"/>
                            </svg>
                        </div>
                        <span>Barang</span>
                    </a>
                    <a href="<?= BASE_URL ?>/admin/supplier/tambah" class="qa-card">
                        <div class="qa-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <line x1="19" y1="8" x2="19" y2="14"/>
                                <line x1="22" y1="11" x2="16" y2="11"/>
                            </svg>
                        </div>
                        <span>Supplier</span>
                    </a>
                    <a href="<?= BASE_URL ?>/admin/pemasokan/tambah" class="qa-card">
                        <div class="qa-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="1" y="3" width="15" height="13" rx="2"/>
                                <path d="M16 8h4l3 3v5h-7V8z"/>
                                <circle cx="5.5" cy="18.5" r="2.5"/>
                                <circle cx="18.5" cy="18.5" r="2.5"/>
                            </svg>
                        </div>
                        <span>Pemasokan</span>
                    </a>
                    <a href="<?= BASE_URL ?>/admin/laporan" class="qa-card">
                        <div class="qa-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                                <line x1="16" y1="13" x2="8" y2="13"/>
                                <line x1="16" y1="17" x2="8" y2="17"/>
                                <polyline points="10 9 9 9 8 9"/>
                            </svg>
                        </div>
                        <span>Laporan</span>
                    </a>
                </div>
            </div>

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

            <div class="bottom">
                <div class="box">
                    <h3>Barang Stok Rendah</h3>
                    <div class="table-wrap">
                        <table class="table">
                            <thead>
                                <tr><th>Barang</th><th>Stok</th><th>Status</th><th>Aksi</th></tr>
                            </thead>
                           <tbody>
<?php if (!empty($data['stok_rendah'])): ?>
    <?php foreach ($data['stok_rendah'] as $barang): ?>
        <tr>
            <td><?= htmlspecialchars($barang['nama']) ?></td>

            <td>
                <?= $barang['stok'] ?>
                <?= $barang['satuan'] ?? '' ?>
            </td>

            <td>
                <?php if ((int)$barang['stok'] <= 0): ?>
                    <span class="badge habis">Habis</span>
                <?php else: ?>
                    <span class="badge stok-rendah">
                        Stok Rendah
                    </span>
                <?php endif; ?>
            </td>

            <td>
                <a href="<?= BASE_URL ?>/admin/barang"
                   class="link">
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
                    <p class="empty">Belum ada pemasokan</p>
                </div>
            </div>

        </div>
    </main>
</div>
<?php require_once ROOT . '/views/layout/footer.php'; ?>
</body>
</html>