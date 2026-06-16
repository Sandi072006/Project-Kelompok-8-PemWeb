<?php
$barang = $data['barang'] ?? [];

$id = (int)($barang['id'] ?? 0);
$kode = $barang['kode'] ?? '-';
$nama = $barang['nama'] ?? ($barang['nama_barang'] ?? '-');
$kategori = $barang['kategori'] ?? '-';
$merek = $barang['merek'] ?? '-';
$supplier = $barang['nama_supplier'] ?? '-';
$satuan = $barang['satuan'] ?? '';

$stok = (int)($barang['stok'] ?? 0);
$stokMinimum = (int)($barang['stok_minimum'] ?? 0);
$hargaBeli = (float)($barang['harga_beli'] ?? 0);
$hargaJual = (float)($barang['harga_jual'] ?? 0);

$labaPerSatuan = $hargaJual - $hargaBeli;
$nilaiStok = $stok * $hargaBeli;

$deskripsi = trim($barang['deskripsi'] ?? '');
$statusAktif = $barang['status_aktif'] ?? 'aktif';

$createdAt = $barang['created_at'] ?? null;
$tanggalDitambahkan = !empty($createdAt) ? date('d M Y', strtotime($createdAt)) : '-';

if ($stok <= 0) {
    $statusText = 'Habis';
    $statusClass = 'badge-habis';
} elseif ($stok <= $stokMinimum) {
    $statusText = 'Stok Rendah';
    $statusClass = 'badge-rendah';
} else {
    $statusText = 'Tersedia';
    $statusClass = 'badge-tersedia';
}

$riwayatMasuk = $data['riwayat_masuk'] ?? [];
$riwayatKeluar = $data['riwayat_keluar'] ?? [];
?>

<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Detail Barang — StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
<body>
<div class="layout">

    <?php $aktif = 'barang'; require_once ROOT . '/views/layout/sidebar.php'; ?>

    <main class="main-content">
        <?php require_once ROOT . '/views/layout/topbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <div class="breadcrumb">
                        <a href="<?= BASE_URL ?>/barang">Data Barang</a>
                        <span>›</span>
                        <span>Detail Barang</span>
                    </div>
                    <h1>Detail Barang</h1>
                    <p>Informasi lengkap data barang</p>
                </div>

                <a href="<?= BASE_URL ?>/barang" class="btn gray">Kembali</a>
            </div>

            <div class="card detail-card">
                <div class="card-header detail-card-header">
                    <div>
                        <h3>
                            <?= htmlspecialchars($kode) ?>
                            —
                            <?= htmlspecialchars($nama) ?>
                        </h3>
                        <p>Tanggal ditambahkan: <?= htmlspecialchars($tanggalDitambahkan) ?></p>
                    </div>

                    <span class="badge-status <?= $statusClass ?>">
                        <?= htmlspecialchars($statusText) ?>
                    </span>
                </div>

                <div class="card-body">

                    <div class="detail-summary">
                        <div class="summary-item">
                            <span>Stok Saat Ini</span>
                            <strong><?= $stok ?> <?= htmlspecialchars($satuan) ?></strong>
                        </div>

                        <div class="summary-item">
                            <span>Stok Minimum</span>
                            <strong><?= $stokMinimum ?> <?= htmlspecialchars($satuan) ?></strong>
                        </div>

                        <div class="summary-item">
                            <span>Nilai Stok</span>
                            <strong>Rp <?= number_format($nilaiStok, 0, ',', '.') ?></strong>
                        </div>

                        <div class="summary-item">
                            <span>Laba / Satuan</span>
                            <strong>Rp <?= number_format($labaPerSatuan, 0, ',', '.') ?></strong>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h4>Informasi Barang</h4>

                        <div class="detail-grid">
                            <div>
                                <div class="detail-row">
                                    <span class="detail-label">Kode Barang</span>
                                    <span class="detail-value"><?= htmlspecialchars($kode) ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Nama Barang</span>
                                    <span class="detail-value"><?= htmlspecialchars($nama) ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Kategori</span>
                                    <span class="detail-value"><?= htmlspecialchars($kategori) ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Merek</span>
                                    <span class="detail-value"><?= htmlspecialchars($merek) ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Supplier</span>
                                    <span class="detail-value"><?= htmlspecialchars($supplier) ?></span>
                                </div>
                            </div>

                            <div>
                                <div class="detail-row">
                                    <span class="detail-label">Satuan</span>
                                    <span class="detail-value"><?= htmlspecialchars($satuan ?: '-') ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Harga Beli</span>
                                    <span class="detail-value">Rp <?= number_format($hargaBeli, 0, ',', '.') ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Harga Jual</span>
                                    <span class="detail-value">Rp <?= number_format($hargaJual, 0, ',', '.') ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Status Stok</span>
                                    <span class="detail-value">
                                        <span class="badge-status <?= $statusClass ?>">
                                            <?= htmlspecialchars($statusText) ?>
                                        </span>
                                    </span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Status Data</span>
                                    <span class="detail-value">
                                        <span class="badge-status <?= $statusAktif === 'aktif' ? 'badge-aktif' : 'badge-nonaktif' ?>">
                                            <?= htmlspecialchars(ucfirst($statusAktif)) ?>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="detail-row detail-full">
                            <span class="detail-label">Deskripsi</span>
                            <span class="detail-value">
                                <?= $deskripsi !== '' ? nl2br(htmlspecialchars($deskripsi)) : 'Belum ada deskripsi barang.' ?>
                            </span>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h4>Riwayat Barang Masuk</h4>

                        <div class="table-responsive">
                            <table class="detail-table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Kode</th>
                                        <th>Jumlah</th>
                                        <th>Supplier</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($riwayatMasuk)): ?>
                                    <?php foreach ($riwayatMasuk as $masuk): ?>
                                        <?php
                                        $tanggalMasuk = !empty($masuk['tanggal']) ? date('d-m-Y', strtotime($masuk['tanggal'])) : '-';
                                        $kodeMasuk = $masuk['kode'] ?? ($masuk['kode_pemasokan'] ?? '-');
                                        $jumlahMasuk = (int)($masuk['jumlah'] ?? 0);
                                        $supplierMasuk = $masuk['nama_supplier'] ?? '-';
                                        $statusMasuk = $masuk['status'] ?? 'aktif';
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($tanggalMasuk) ?></td>
                                            <td><?= htmlspecialchars($kodeMasuk) ?></td>
                                            <td><?= $jumlahMasuk ?> <?= htmlspecialchars($satuan) ?></td>
                                            <td><?= htmlspecialchars($supplierMasuk) ?></td>
                                            <td>
                                                <span class="badge-status <?= $statusMasuk === 'aktif' ? 'badge-aktif' : 'badge-nonaktif' ?>">
                                                    <?= htmlspecialchars(ucfirst($statusMasuk)) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="empty-row">Belum ada riwayat barang masuk.</td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h4>Riwayat Barang Keluar</h4>

                        <div class="table-responsive">
                            <table class="detail-table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Kode</th>
                                        <th>Jumlah</th>
                                        <th>Tujuan</th>
                                        <th>Catatan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($riwayatKeluar)): ?>
                                    <?php foreach ($riwayatKeluar as $keluar): ?>
                                        <?php
                                        $tanggalKeluar = !empty($keluar['tanggal']) ? date('d-m-Y', strtotime($keluar['tanggal'])) : '-';
                                        $kodeKeluar = $keluar['kode'] ?? ($keluar['kode_stock_out'] ?? '-');
                                        $jumlahKeluar = (int)($keluar['jumlah'] ?? 0);
                                        $tujuanKeluar = $keluar['tujuan'] ?? ($keluar['keterangan'] ?? '-');
                                        $catatanKeluar = $keluar['catatan'] ?? '-';
                                        $statusKeluar = $keluar['status'] ?? 'aktif';
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($tanggalKeluar) ?></td>
                                            <td><?= htmlspecialchars($kodeKeluar) ?></td>
                                            <td><?= $jumlahKeluar ?> <?= htmlspecialchars($satuan) ?></td>
                                            <td><?= htmlspecialchars($tujuanKeluar ?: '-') ?></td>
                                            <td><?= htmlspecialchars($catatanKeluar ?: '-') ?></td>
                                            <td>
                                                <span class="badge-status <?= $statusKeluar === 'aktif' ? 'badge-aktif' : 'badge-nonaktif' ?>">
                                                    <?= htmlspecialchars(ucfirst($statusKeluar)) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="empty-row">Belum ada riwayat barang keluar.</td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>
</div>

<?php require_once ROOT . '/views/layout/footer.php'; ?>
</body>
</html>
