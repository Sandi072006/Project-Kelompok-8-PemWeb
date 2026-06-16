<?php
$supplier = $data['supplier'] ?? [];
$pemasokan = $data['pemasokan'] ?? [];

$supplierId = (int)($supplier['id'] ?? 0);
$kodeSupplier = $supplier['kode'] ?? '';
$perusahaan = $supplier['perusahaan'] ?? '-';
$nama = $supplier['nama'] ?? '-';
$telepon = $supplier['telepon'] ?? '-';
$email = $supplier['email'] ?? '-';
$alamat = $supplier['alamat'] ?? '-';
$kategori = $supplier['kategori'] ?? '-';
$status = $supplier['status'] ?? 'aktif';
$catatan = trim($supplier['catatan'] ?? '');

$createdAt = $supplier['created_at'] ?? null;
$tanggalDaftar = !empty($createdAt) ? date('d-m-Y', strtotime($createdAt)) : '-';

$totalTransaksi = count($pemasokan);
$totalTransaksiAktif = 0;
$totalBarangMasuk = 0;
$totalNilaiPemasokan = 0;

foreach ($pemasokan as $p) {
    $statusPemasokan = $p['status'] ?? 'aktif';

    if ($statusPemasokan === 'aktif') {
        $jumlah = (int)($p['jumlah'] ?? 0);
        $hargaBeli = (float)($p['harga_beli'] ?? 0);
        $total = isset($p['total']) ? (float)$p['total'] : ($jumlah * $hargaBeli);

        $totalTransaksiAktif++;
        $totalBarangMasuk += $jumlah;
        $totalNilaiPemasokan += $total;
    }
}

$statusClass = $status === 'aktif' ? 'badge-aktif' : 'badge-nonaktif';
?>

<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Detail Supplier — StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
<body>
<div class="layout">

    <?php $aktif = 'supplier'; require_once ROOT . '/views/layout/sidebar.php'; ?>

    <main class="main-content">
        <?php require_once ROOT . '/views/layout/topbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <div class="breadcrumb">
                        <a href="<?= BASE_URL ?>/supplier">Data Supplier</a>
                        <span>›</span>
                        <span>Detail Supplier</span>
                    </div>
                    <h1>Detail Supplier</h1>
                    <p>Informasi lengkap supplier dan riwayat pemasokan</p>
                </div>

                <a href="<?= BASE_URL ?>/supplier" class="btn gray">Kembali</a>
            </div>

            <div class="card detail-card">
                <div class="card-header detail-card-header">
                    <div>
                    <h3>
                        <?= htmlspecialchars($perusahaan) ?>
                    </h3>
                        <p>Terdaftar sejak: <?= htmlspecialchars($tanggalDaftar) ?></p>
                    </div>

                    <span class="badge-status <?= $statusClass ?>">
                        <?= htmlspecialchars(ucfirst($status)) ?>
                    </span>
                </div>

                <div class="card-body">

                    <div class="detail-summary">
                        <div class="summary-item">
                            <span>Total Transaksi</span>
                            <strong><?= $totalTransaksi ?></strong>
                        </div>

                        <div class="summary-item">
                            <span>Transaksi Aktif</span>
                            <strong><?= $totalTransaksiAktif ?></strong>
                        </div>

                        <div class="summary-item">
                            <span>Total Barang Masuk</span>
                            <strong><?= $totalBarangMasuk ?></strong>
                        </div>

                        <div class="summary-item">
                            <span>Total Nilai Pemasokan</span>
                            <strong>Rp <?= number_format($totalNilaiPemasokan, 0, ',', '.') ?></strong>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h4>Informasi Supplier</h4>

                        <div class="detail-grid">
                            <div>
                                <div class="detail-row">
                                    <span class="detail-label">Nama Perusahaan</span>
                                    <span class="detail-value"><?= htmlspecialchars($perusahaan ?: '-') ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Nama Penanggung Jawab</span>
                                    <span class="detail-value"><?= htmlspecialchars($nama ?: '-') ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Kategori Produk</span>
                                    <span class="detail-value"><?= htmlspecialchars($kategori ?: '-') ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Status</span>
                                    <span class="detail-value">
                                        <span class="badge-status <?= $statusClass ?>">
                                            <?= htmlspecialchars(ucfirst($status)) ?>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div>
                                <div class="detail-row">
                                    <span class="detail-label">Nomor Telepon</span>
                                    <span class="detail-value"><?= htmlspecialchars($telepon ?: '-') ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Email</span>
                                    <span class="detail-value"><?= htmlspecialchars($email ?: '-') ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Alamat</span>
                                    <span class="detail-value"><?= htmlspecialchars($alamat ?: '-') ?></span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Catatan</span>
                                    <span class="detail-value">
                                        <?= $catatan !== '' ? nl2br(htmlspecialchars($catatan)) : 'Belum ada catatan supplier.' ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h4>Riwayat Pemasokan dari Supplier Ini</h4>

                        <div class="table-responsive">
                            <table class="detail-table">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Tanggal</th>
                                        <th>Barang</th>
                                        <th>Jumlah</th>
                                        <th>Harga Beli</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php if (!empty($pemasokan)): ?>
                                    <?php foreach ($pemasokan as $p): ?>
                                        <?php
                                        $pemasokanId = (int)($p['id'] ?? 0);
                                        $kodePemasokan = $p['kode'] ?? '-';

                                        $tanggal = $p['tanggal'] ?? ($p['tanggal_pemasokan'] ?? null);
                                        $tanggalFormatted = !empty($tanggal) ? date('d-m-Y', strtotime($tanggal)) : '-';

                                        $kodeBarang = $p['kode_barang'] ?? '-';
                                        $namaBarang = $p['nama_barang'] ?? '-';
                                        $satuan = $p['satuan'] ?? '';

                                        $jumlah = (int)($p['jumlah'] ?? 0);
                                        $hargaBeli = (float)($p['harga_beli'] ?? 0);
                                        $total = isset($p['total']) ? (float)$p['total'] : ($jumlah * $hargaBeli);

                                        $statusPemasokan = $p['status'] ?? 'aktif';
                                        $statusPemasokanClass = $statusPemasokan === 'aktif' ? 'badge-aktif' : 'badge-nonaktif';
                                        ?>
                                        <tr>
                                            <td>
                                                <strong><?= htmlspecialchars($kodePemasokan) ?></strong>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($tanggalFormatted) ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($kodeBarang) ?>
                                                —
                                                <?= htmlspecialchars($namaBarang) ?>
                                            </td>

                                            <td>
                                                <?= $jumlah ?>
                                                <?= htmlspecialchars($satuan) ?>
                                            </td>

                                            <td>
                                                Rp <?= number_format($hargaBeli, 0, ',', '.') ?>
                                            </td>

                                            <td>
                                                Rp <?= number_format($total, 0, ',', '.') ?>
                                            </td>

                                            <td>
                                                <span class="badge-status <?= $statusPemasokanClass ?>">
                                                    <?= htmlspecialchars(ucfirst($statusPemasokan)) ?>
                                                </span>
                                            </td>

                                            <td>
                                                <a href="<?= BASE_URL ?>/pemasokan/detail?id=<?= $pemasokanId ?>" class="link">
                                                    Lihat
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="empty-row">
                                            Belum ada riwayat pemasokan dari supplier ini.
                                        </td>
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