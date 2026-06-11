<!DOCTYPE html>
<html lang="id">
<?php $pageTitle = 'Edit Barang — Admin StockMate'; require_once ROOT . '/views/layout/header.php'; ?>
<body>
<div class="layout">

    <?php $aktif = 'barang'; require_once ROOT . '/views/layout/sidebar_admin.php'; ?>

    <main class="main-content">
        <?php require_once ROOT . '/views/layout/topbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <div class="breadcrumb">
                        <a href="<?= BASE_URL ?>/admin/barang">Data Barang</a>
                        <span>›</span>
                        <span>Edit Barang</span>
                    </div>
                    <h1>Edit Barang</h1>
                    <p>Ubah data barang yang sudah ada</p>
                </div>
                <a href="<?= BASE_URL ?>/admin/barang" class="btn gray">Kembali</a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Form Edit Barang</h3>
                    <p>Field sudah terisi otomatis dari data yang dipilih</p>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/admin/barang/update" method="POST">
                        <input type="hidden" name="id" value="<?= (int)($data['barang']['id'] ?? 0) ?>">
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Kode Barang</label>
                                <input type="text" name="kode" value="<?= htmlspecialchars($data['barang']['kode'] ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Nama Barang</label>
                                <input type="text" name="nama" value="<?= htmlspecialchars($data['barang']['nama'] ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="kategori" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach (['Makanan','Minuman','Kebersihan','Bumbu','Snack'] as $kat): ?>
                                        <option value="<?= $kat ?>" <?= ($data['barang']['kategori'] ?? '') === $kat ? 'selected' : '' ?>><?= $kat ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Merek</label>
                                <input type="text" name="merek" value="<?= htmlspecialchars($data['barang']['merek'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label>Supplier</label>
                                <select name="supplier_id" required>
                                    <option value="">-- Pilih Supplier --</option>
                                    <?php if (!empty($data['suppliers'])): ?>
                                        <?php foreach ($data['suppliers'] as $s): ?>
                                            <option value="<?= (int)$s['id'] ?>" <?= ($data['barang']['supplier_id'] ?? 0) == $s['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($s['perusahaan']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Stok Saat Ini</label>
                                <input type="number" name="stok" value="<?= (int)($data['barang']['stok'] ?? 0) ?>" min="0" required>
                            </div>
                            <div class="form-group">
                                <label>Satuan</label>
                                <input type="text" name="satuan" value="<?= htmlspecialchars($data['barang']['satuan'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label>Stok Minimum</label>
                                <input type="number" name="stok_minimum" value="<?= (int)($data['barang']['stok_minimum'] ?? 0) ?>" min="0">
                            </div>
                            <div class="form-group">
                                <label>Harga Beli</label>
                                <input type="number" name="harga_beli" value="<?= (int)($data['barang']['harga_beli'] ?? 0) ?>" min="0" required>
                            </div>
                            <div class="form-group">
                                <label>Harga Jual</label>
                                <input type="number" name="harga_jual" value="<?= (int)($data['barang']['harga_jual'] ?? 0) ?>" min="0" required>
                            </div>
                            <div class="form-group form-full">
                                <label>Deskripsi <span class="label-optional">(opsional)</span></label>
                                <textarea rows="3" name="deskripsi"><?= htmlspecialchars($data['barang']['deskripsi'] ?? '') ?></textarea>
                            </div>
                        </div>
                        <div style="padding:20px 0 0;border-top:1px solid #e2e8f0;margin-top:20px;display:flex;justify-content:flex-end;gap:10px;">
                            <a href="<?= BASE_URL ?>/admin/barang" class="btn-secondary">Batal</a>
                            <button type="submit" class="btn-primary">Simpan Perubahan</button>
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