<!DOCTYPE html>
<html lang="id">

<?php
$pageTitle = 'Laporan — Admin StockMate';
require_once ROOT . '/views/layout/header.php';

$barangList = Barang::getAll();
$stokRendah = Barang::getStokRendah();
$supplierList = Supplier::getAll();
$pemasokanList = Pemasokan::getAll();
$stockOutList = StockOut::getAll();

$totalNilaiStok = 0;
$barangHabis = 0;
$stokMax = 0;

foreach ($barangList as $b) {
    $stok = (int)$b['stok'];
    $hargaBeli = (int)$b['harga_beli'];

    $totalNilaiStok += $stok * $hargaBeli;

    if ($stok <= 0) {
        $barangHabis++;
    }

    if ($stok > $stokMax) {
        $stokMax = $stok;
    }
}

$supplierAktif = 0;
foreach ($supplierList as $s) {
    if (strtolower($s['status']) === 'aktif') {
        $supplierAktif++;
    }
}
?>

<body>

<div class="layout">

    <?php
    $aktif = 'laporan';
    require_once ROOT . '/views/layout/sidebar_admin.php';
    ?>

    <main class="main-content">

        <?php require_once ROOT . '/views/layout/topbar.php'; ?>

        <div class="content">

            <div class="page-header">
                <div class="page-title">
                    <h1>Laporan</h1>
                    <p>Rekap data stok, supplier, dan pemasokan</p>
                </div>
            </div>

            <div class="cards" style="grid-template-columns: repeat(4, 1fr);">

                <div class="stat-card">
                    <p>Total Nilai Stok</p>
                    <h2>Rp <?= number_format($totalNilaiStok, 0, ',', '.') ?></h2>
                    <span>Estimasi nilai inventaris</span>
                </div>

                <div class="stat-card">
                    <p>Total Pemasokan</p>
                    <h2><?= count($pemasokanList) ?></h2>
                    <span>Transaksi tercatat</span>
                </div>

                <div class="stat-card">
                    <p>Total Stock Out</p>
                    <h2><?= count($stockOutList) ?></h2>
                    <span>Transaksi keluar</span>
                </div>

                <div class="stat-card">
                    <p>Supplier Aktif</p>
                    <h2><?= $supplierAktif ?></h2>
                    <span>Dari <?= count($supplierList) ?> supplier terdaftar</span>
                </div>

                <div class="stat-card">
                    <p>Barang Stok Rendah</p>
                    <h2><?= count($stokRendah) ?></h2>
                    <span>Perlu restock segera</span>
                </div>

                <div class="stat-card">
                    <p>Total Jenis Barang</p>
                    <h2><?= count($barangList) ?></h2>
                    <span>Item terdaftar di sistem</span>
                </div>

                <div class="stat-card">
                    <p>Barang Habis</p>
                    <h2><?= $barangHabis ?></h2>
                    <span>Stok = 0</span>
                </div>

            </div>

            <div class="lap-bottom">

                <div class="box">

                    <div class="section-title">
                        Kondisi Stok Seluruh Barang
                    </div>

                    <div>
                        <?php if (!empty($barangList)): ?>
                            <?php foreach ($barangList as $barang): ?>
                                <?php
                                $stok = (int)$barang['stok'];
                                $stokMinimum = (int)($barang['stok_minimum'] ?? 0);
                                $persen = $stokMax > 0 ? ($stok / $stokMax) * 100 : 0;

                                if ($stok <= 0) {
                                    $classBar = 'zero';
                                    $teksStok = 'Habis';
                                } elseif ($stok <= $stokMinimum) {
                                    $classBar = 'low';
                                    $teksStok = $stok . ' ' . ($barang['satuan'] ?? '');
                                } else {
                                    $classBar = '';
                                    $teksStok = $stok . ' ' . ($barang['satuan'] ?? '');
                                }
                                ?>

                                <div class="bar-meta">
                                    <span class="bar-name">
                                        <?= htmlspecialchars($barang['nama'] ?? '') ?>
                                    </span>
                                    <span class="bar-count">
                                        <?= htmlspecialchars($teksStok ?? '') ?>
                                    </span>
                                </div>

                                <div class="bar-track">
                                    <div class="bar-fill <?= $classBar ?>"
                                         style="width:<?= $stok <= 0 ? 0 : max($persen, 3) ?>%">
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="empty">Belum ada data barang</p>
                        <?php endif; ?>
                    </div>

                </div>

                <div style="display:flex;flex-direction:column;gap:16px;">

                    <div class="box">

                        <div class="section-title">
                            Barang Perlu Perhatian
                        </div>

                        <div class="table-wrap">

                            <table class="table">

                                <thead>
                                    <tr>
                                        <th>Barang</th>
                                        <th>Stok</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (!empty($stokRendah)): ?>
                                        <?php foreach ($stokRendah as $barang): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($barang['nama'] ?? '') ?></td>
                                                <td>
                                                    <?= htmlspecialchars($barang['stok'] ?? '') ?>
                                                    <?= htmlspecialchars($barang['satuan'] ?? '') ?>
                                                </td>
                                                <td>
                                                    <?php if ((int)$barang['stok'] <= 0): ?>
                                                        <img src="<?= BASE_URL ?>/assets/img/wrong.svg"
                                                             style="width:22px;height:22px;"
                                                             alt="Habis">
                                                    <?php else: ?>
                                                        <img src="<?= BASE_URL ?>/assets/img/warning.svg"
                                                             style="width:22px;height:22px;"
                                                             alt="Stok Rendah">
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" style="text-align:center;">
                                                Tidak ada barang perlu perhatian
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>

                            </table>

                        </div>

                    </div>

                    <div class="box">

                        <div class="section-title">
                            Riwayat Pemasokan
                        </div>

                        <div class="table-wrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Barang</th>
                                        <th>Supplier</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (!empty($pemasokanList)): ?>
                                        <?php foreach ($pemasokanList as $p): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($p['kode'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($p['nama_barang'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($p['nama_supplier'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($p['jumlah'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($p['tanggal'] ?? '') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" style="text-align:center;">
                                                Belum ada pemasokan tercatat
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="box">

                        <div class="section-title">
                            Riwayat Stock Out
                        </div>

                        <div class="table-wrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Barang</th>
                                        <th>Jumlah</th>
                                        <th>Tujuan</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (!empty($stockOutList)): ?>
                                        <?php foreach ($stockOutList as $so): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($so['kode'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($so['nama_barang'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($so['jumlah'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($so['tujuan'] ?? '-') ?></td>
                                                <td><?= htmlspecialchars($so['tanggal'] ?? '') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" style="text-align:center;">
                                                Belum ada stock out tercatat
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

            </div>

            <div class="box" style="margin-top:16px;">

                <div class="section-title">
                    Rekap Supplier
                </div>

                <div class="table-wrap">

                    <table class="table">

                        <thead>
                            <tr>
                                <th>Nama Perusahaan</th>
                                <th>Penanggung Jawab</th>
                                <th>Telepon</th>
                                <th>Kategori</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($supplierList)): ?>
                                <?php foreach ($supplierList as $supplier): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($supplier['perusahaan'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($supplier['nama'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($supplier['telepon'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($supplier['kategori'] ?? '-') ?></td>
                                        <td>
                                            <?php if (strtolower($supplier['status']) === 'aktif'): ?>
                                                <img src="<?= BASE_URL ?>/assets/img/check.svg"
                                                     style="width:22px;height:22px;"
                                                     alt="Aktif">
                                            <?php else: ?>
                                                <img src="<?= BASE_URL ?>/assets/img/wrong.svg"
                                                     style="width:22px;height:22px;"
                                                     alt="Nonaktif">
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align:center;">
                                        Belum ada data supplier
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