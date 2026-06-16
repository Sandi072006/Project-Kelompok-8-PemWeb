<?php
$isAdmin = ($_SESSION['role'] ?? '') === 'admin';

$p = $data['pemasokan'] ?? [];

$id = (int)($p['id'] ?? 0);
$kode = $p['kode'] ?? '-';
$tanggal = $p['tanggal'] ?? null;
$createdAt = $p['created_at'] ?? null;

$barangId = (int)($p['barang_id'] ?? 0);
$kodeBarang = $p['kode_barang'] ?? '-';
$namaBarang = $p['nama_barang'] ?? '-';
$kategoriBarang = $p['kategori_barang'] ?? '-';
$merekBarang = $p['merek_barang'] ?? '-';
$satuan = $p['satuan'] ?? '';

$supplierId = (int)($p['supplier_id'] ?? 0);
$namaSupplier = $p['nama_supplier'] ?? '-';
$penanggungJawab = $p['nama_penanggung_jawab'] ?? '-';
$kontakSupplier = $p['kontak_supplier'] ?? '-';
$emailSupplier = $p['email_supplier'] ?? '-';
$alamatSupplier = $p['alamat_supplier'] ?? '-';

$jumlah = (int)($p['jumlah'] ?? 0);
$hargaBeli = (float)($p['harga_beli'] ?? 0);
$total = isset($p['total']) ? (float)$p['total'] : ($jumlah * $hargaBeli);
$hargaJual = (float)($p['harga_jual'] ?? 0);
$estimasiNilaiJual = $jumlah * $hargaJual;

$stokSaatIni = (int)($p['stok_saat_ini'] ?? 0);
$stokMinimum = (int)($p['stok_minimum'] ?? 0);

$petugas = $p['petugas'] ?? 'petugas';
$status = $p['status'] ?? 'aktif';
$catatan = trim($p['catatan'] ?? '');

$cancelledAt = $p['cancelled_at'] ?? null;
$dibatalkanOleh = $p['dibatalkan_oleh'] ?? '-';

$tanggalFormatted = !empty($tanggal) ? date('d-m-Y', strtotime($tanggal)) : '-';
$tanggalHeader = !empty($tanggal) ? date('d F Y', strtotime($tanggal)) : '-';
$createdFormatted = !empty($createdAt) ? date('d-m-Y H:i', strtotime($createdAt)) : '-';
$cancelledFormatted = !empty($cancelledAt) ? date('d-m-Y H:i', strtotime($cancelledAt)) : '-';

$statusClass = $status === 'aktif' ? 'badge-aktif' : 'badge-nonaktif';

$basePemasokanUrl = $isAdmin ? BASE_URL . '/admin/pemasokan' : BASE_URL . '/pemasokan';
$baseBarangUrl = $isAdmin ? BASE_URL . '/admin/barang' : BASE_URL . '/barang';
$baseSupplierUrl = $isAdmin ? BASE_URL . '/admin/supplier' : BASE_URL . '/supplier';
?>

<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Detail Pemasokan — StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
<body>
<div class="layout">

    <?php
    $aktif = 'pemasokan';
    require_once ROOT . ($isAdmin ? '/views/layout/sidebar_admin.php' : '/views/layout/sidebar.php');
    ?>

    <main class="main-content">
        <?php require_once ROOT . '/views/layout/topbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <div class="breadcrumb">
                        <a href="<?= $basePemasokanUrl ?>">Barang Masuk</a>
                        <span>›</span>
                        <span>Detail Pemasokan</span>
                    </div>
                    <h1>Detail Pemasokan</h1>
                    <p>Informasi lengkap transaksi barang masuk</p>
                </div>

                <div style="display:flex;gap:10px;">
                    <?php if ($status === 'aktif'): ?>
                        <a href="#modal-batalkan" class="btn-delete">Batalkan</a>
                    <?php endif; ?>

                    <a href="<?= $basePemasokanUrl ?>" class="btn gray">Kembali</a>
                </div>
            </div>

            <div class="card detail-card">
                <div class="card-header detail-card-header">
                    <div>
                        <h3><?= htmlspecialchars($kode) ?> — <?= htmlspecialchars($tanggalHeader) ?></h3>
                        <p>Dicatat oleh <?= htmlspecialchars($petugas) ?> pada <?= htmlspecialchars($createdFormatted) ?></p>
                    </div>

                    <span class="badge-status <?= $statusClass ?>">
                        <?= htmlspecialchars(ucfirst($status)) ?>
                    </span>
                </div>

                <div class="card-body">

                    <div class="detail-summary">
                        <div class="summary-item">
                            <span>Jumlah Masuk</span>
                            <strong><?= $jumlah ?> <?= htmlspecialchars($satuan) ?></strong>
                        </div>

                        <div class="summary-item">
                            <span>Harga Beli Satuan</span>
                            <strong>Rp <?= number_format($hargaBeli, 0, ',', '.') ?></strong>
                        </div>

                        <div class="summary-item">
                            <span>Total Pembelian</span>
                            <strong>Rp <?= number_format($total, 0, ',', '.') ?></strong>
                        </div>

                        <div class="summary-item">
                            <span>Estimasi Nilai Jual</span>
                            <strong>Rp <?= number_format($estimasiNilaiJual, 0, ',', '.') ?></strong>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h4>Informasi Transaksi</h4>

                        <div class="detail-grid">
                            <div>
                                <div class="detail-row">
                                    <span class="detail-label">Kode Pemasokan</span>
                                    <span class="detail-value"><?= htmlspecialchars($kode) ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Tanggal Pemasokan</span>
                                    <span class="detail-value"><?= htmlspecialchars($tanggalFormatted) ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Petugas Pencatat</span>
                                    <span class="detail-value"><?= htmlspecialchars($petugas) ?></span>
                                </div>
                            </div>

                            <div>
                                <div class="detail-row">
                                    <span class="detail-label">Status Transaksi</span>
                                    <span class="detail-value">
                                        <span class="badge-status <?= $statusClass ?>">
                                            <?= htmlspecialchars(ucfirst($status)) ?>
                                        </span>
                                    </span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Waktu Input</span>
                                    <span class="detail-value"><?= htmlspecialchars($createdFormatted) ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Catatan</span>
                                    <span class="detail-value">
                                        <?= $catatan !== '' ? nl2br(htmlspecialchars($catatan)) : 'Tidak ada catatan.' ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h4>Informasi Barang</h4>

                        <div class="detail-grid">
                            <div>
                                <div class="detail-row">
                                    <span class="detail-label">Kode Barang</span>
                                    <span class="detail-value"><?= htmlspecialchars($kodeBarang) ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Nama Barang</span>
                                    <span class="detail-value"><?= htmlspecialchars($namaBarang) ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Kategori</span>
                                    <span class="detail-value"><?= htmlspecialchars($kategoriBarang) ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Merek</span>
                                    <span class="detail-value"><?= htmlspecialchars($merekBarang) ?></span>
                                </div>
                            </div>

                            <div>
                                <div class="detail-row">
                                    <span class="detail-label">Jumlah Masuk</span>
                                    <span class="detail-value"><?= $jumlah ?> <?= htmlspecialchars($satuan) ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Stok Saat Ini</span>
                                    <span class="detail-value"><?= $stokSaatIni ?> <?= htmlspecialchars($satuan) ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Stok Minimum</span>
                                    <span class="detail-value"><?= $stokMinimum ?> <?= htmlspecialchars($satuan) ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Detail Barang</span>
                                    <span class="detail-value">
                                        <a href="<?= $baseBarangUrl ?>/detail?id=<?= $barangId ?>" class="link">Lihat Barang</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h4>Informasi Supplier</h4>

                        <div class="detail-grid">
                            <div>
                                <div class="detail-row">
                                    <span class="detail-label">Nama Supplier</span>
                                    <span class="detail-value"><?= htmlspecialchars($namaSupplier) ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Penanggung Jawab</span>
                                    <span class="detail-value"><?= htmlspecialchars($penanggungJawab) ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Nomor Telepon</span>
                                    <span class="detail-value"><?= htmlspecialchars($kontakSupplier) ?></span>
                                </div>
                            </div>

                            <div>
                                <div class="detail-row">
                                    <span class="detail-label">Email</span>
                                    <span class="detail-value"><?= htmlspecialchars($emailSupplier) ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Alamat</span>
                                    <span class="detail-value"><?= htmlspecialchars($alamatSupplier) ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Detail Supplier</span>
                                    <span class="detail-value">
                                        <a href="<?= $baseSupplierUrl ?>/detail?id=<?= $supplierId ?>" class="link">Lihat Supplier</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($status === 'dibatalkan'): ?>
                        <div class="detail-section">
                            <h4>Informasi Pembatalan</h4>

                            <div class="detail-grid">
                                <div>
                                    <div class="detail-row">
                                        <span class="detail-label">Dibatalkan Oleh</span>
                                        <span class="detail-value"><?= htmlspecialchars($dibatalkanOleh) ?></span>
                                    </div>
                                </div>

                                <div>
                                    <div class="detail-row">
                                        <span class="detail-label">Waktu Pembatalan</span>
                                        <span class="detail-value"><?= htmlspecialchars($cancelledFormatted) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </main>
</div>

<?php if ($status === 'aktif'): ?>
<div class="modal" id="modal-batalkan">
    <div class="modal-box">
        <a href="#" class="close">&times;</a>
        <h2>Batalkan Pemasokan</h2>
        <p>
            Yakin ingin membatalkan transaksi
            <strong><?= htmlspecialchars($kode) ?></strong>?
            Stok barang akan dikurangi kembali sebanyak
            <strong><?= $jumlah ?> <?= htmlspecialchars($satuan) ?></strong>.
        </p>

        <div style="display:flex;gap:10px;justify-content:flex-end;">
            <a href="#" class="btn-secondary">Batal</a>
            <a href="<?= $basePemasokanUrl ?>/batalkan?id=<?= $id ?>" class="btn-delete" style="padding:9px 16px;">
                Ya, Batalkan
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<?php require_once ROOT . '/views/layout/footer.php'; ?>
</body>
</html>
