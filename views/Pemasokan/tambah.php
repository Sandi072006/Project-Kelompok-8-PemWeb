<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Tambah Pemasokan — StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
<body>
<div class="layout">

    <?php $aktif = 'pemasokan'; require_once ROOT . '/views/layout/sidebar.php'; ?>

    <main class="main-content">
        <?php require_once ROOT . '/views/layout/topbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <div class="breadcrumb">
                        <a href="<?= BASE_URL ?>/pemasokan">Pemasokan</a>
                        <span>›</span>
                        <span>Tambah Pemasokan</span>
                    </div>
                    <h1>Tambah Pemasokan</h1>
                    <p>Catat transaksi pemasokan barang baru</p>
                </div>
                <a href="<?= BASE_URL ?>/pemasokan" class="btn gray">Kembali</a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Form Tambah Pemasokan</h3>
                    <p>Isi semua field yang diperlukan</p>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/pemasokan/simpan" method="POST">
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Tanggal Pemasokan</label>
                                <input type="date" name="tanggal" required>
                            </div>
                            <div class="form-group">
                                <label>Supplier</label>
                                <select name="supplier_id" required>
                                    <option value="">-- Pilih Supplier --</option>
                                    <?php if (!empty($data['supplier'])): ?>
                                        <?php foreach ($data['supplier'] as $s): ?>
                                            <option value="<?= (int)$s['id'] ?>"><?= htmlspecialchars($s['perusahaan']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Barang</label>
                                <select name="barang_id" required>
                                    <option value="">-- Pilih Barang --</option>
                                    <?php if (!empty($data['barang'])): ?>
                                        <?php foreach ($data['barang'] as $b): ?>
                                            <option value="<?= (int)$b['id'] ?>"><?= htmlspecialchars($b['kode'] . ' — ' . $b['nama']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jumlah</label>
                                <input type="number" name="jumlah" placeholder="cth. 100" min="1" required>
                            </div>
                            <div class="form-group">
                                <label>Harga Beli Satuan</label>
                                <input type="number" name="harga_beli" placeholder="cth. 65000" min="0" required>
                            </div>
                            <div class="form-group form-full">
                                <label>Catatan <span class="label-optional">(opsional)</span></label>
                                <textarea name="catatan" rows="3" placeholder="Keterangan tambahan mengenai pemasokan ini..."></textarea>
                            </div>
                        </div>

                        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:16px 20px;margin-top:8px;">
                            <div style="font-size:12px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;">Ringkasan</div>
                            <div style="display:flex;justify-content:space-between;font-size:13.5px;color:#374151;">
                                <span>Total Harga</span>
                                <span style="font-weight:700;color:#0d1117;">Rp 0</span>
                            </div>
                        </div>

                        <div style="padding:20px 0 0;border-top:1px solid #e2e8f0;margin-top:20px;display:flex;justify-content:flex-end;gap:10px;">
                            <a href="<?= BASE_URL ?>/pemasokan" class="btn-secondary">Batal</a>
                            <button type="submit" class="btn-primary">Simpan Pemasokan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
<?php require_once ROOT . '/views/layout/footer.php'; ?>
</body>
</html>
